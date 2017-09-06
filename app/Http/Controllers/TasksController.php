<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Notification;
use App\Models\Priority;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use App\Helpers\Helper;
use DateTime;
use Illuminate\Http\Request;


class TasksController extends Controller
{

    public function index()
    {
        $example = false;
        if (\Auth::user()->isAdmin()) {
            $tasks = Task::all()->whereNotIn('id', [1]);
        } else {
            $tasks = array();
            $tasksUser = TaskUser::whereUserId(\Auth::user()->id)->with('task')->get();
            foreach ($tasksUser as $task) {
                if ($task->task->id == 1) {
                    $example = true;
                }
                array_push($tasks, $task->task);
            }
        }

        if (count($tasks) == 0) {
            $example = true;
            $tasks = Task::whereId(1)->get();
        }

        $data = [
            'example' => $example,
            'tasks' => $tasks
        ];

        return view('pages.tasks', $data);
    }

    public function form($project_id = null)
    {
        $priorities = Priority::pluck('priority', 'id')->map(function ($item, $key) {
            return __('general.priorities.' . $item . '');
        });

        $status = TaskStatus::orderBy('id','asc')->pluck('status', 'id')->map(function ($item, $key) {
            return __('task.' . $item . '');
        });

        $data = [
            'priorities' => $priorities,
            'status' => $status,
            'project_id' => $project_id,
        ];

        return view("pages.user.taskupdate", $data);
    }

    public function detail($action, $id)
    {
        $task = Task::find($id);
        $priorities = Priority::pluck('priority', 'id')->map(function ($item, $key) {
            return __('general.priorities.' . $item . '');
        });

        $status = TaskStatus::orderBy('id','asc')->pluck('status', 'id')->map(function ($item, $key) {
            return __('task.' . $item . '');
        });

        $data = [
            'priorities' => $priorities,
            'status' => $status,
            'task' => $task,
            'project_id' => $task->project_id,
        ];

        return view("pages.user.task$action", $data);
    }

    public function create(TaskRequest $request)
    {
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->priority_id = $request->input('priority');
        $task->status_id = $request->input('status');
        $task->user_id = \Auth::user()->id;
        $task->project_id = $request->input('project_id');

        if (!is_null($request->get('datetimepicker'))) {
            $targetEndDate = DateTime::createFromFormat(Helper::setFormatDate() . ' H:i', $request->get('datetimepicker'));
            $task->target_end_date = $targetEndDate->format('Y-m-d H:i:s');
        }

        try {
            $task->save();

            $recipients = Helper::getRecipients();

            foreach ($recipients as $recipient) {
                $task_user = new TaskUser();
                $task_user->task_id = $task->id;
                $task_user->user_id = $recipient;

                try {
                    $task_user->save();

                } catch (QueryException $ex) {
                    Helper::logExceptionSql($ex);
                    return \Redirect::route('projects')->with('danger', __('project.new_member_ko'))->withInput();
                }
            }

            Notification::add(__('notification.new_task', ['task' => $task->title]), route('tasks'), $task->notification_type, $task->id, $recipients, false);

            return \Redirect::to($request->input('redirect_url'))->with('success', __('task.new_ok'))->withInput();

        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::to($request->input('redirect_url'))->with('danger', __('task.new_ko'))->withInput();
        }
    }

    public function update(TaskRequest $request, $task_id)
    {
        $task = Task::find($task_id);
        if ($task->status_id == 3) {
            return \Redirect::to($request->input('redirect_url'))->with('danger', __('task.forbiddenDone'))->withInput();
        }


        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->priority_id = $request->input('priority');
        $task->status_id = $request->input('status');

        if (!is_null($request->input('datetimepicker')) && (\Auth::user()->isAdmin() || $task->user_id == \Auth::user()->id)) {
            $targetEndDate = DateTime::createFromFormat(Helper::setFormatDate() . ' H:i', $request->input('datetimepicker'));
            $task->target_end_date = $targetEndDate->format('Y-m-d H:i:s');
        }

        if ($request->input('status') == 3) {
            $task->done_user_id = \Auth::user()->id;
            $task->actual_end_date = Carbon::now();
        }

        $hasChanges = false;
        $changes = $task->getDirty();
        if (count($changes) > 0) {
            $hasChanges = true;
            foreach ($changes as $key => $value) {
                $values[] = $task->getChanges($key, $value);
            }
            $values = implode(', ', $values);
            $message = __('notification.update_task', ['task' => $task->title, 'values' => $values]);
        }


        try {
            $task->save();

            $new = $recipients = Helper::getRecipients();
            $members = $task->tasks_users->all();

            foreach ($members as $member) {
                if (in_array($member->user_id, $recipients)) {
                    unset($new[array_search($member->user_id, $new)]);
                } else {
                    TaskUser::whereUserId($member->user_id)->delete();
                    Notification::add(__('notification.delete_member_task', ['task' => $task->title, 'member' => User::find($member->user_id)->getFullName()]), route('task', ['action'=>'detail','id'=>$task_id]), $task->notification_type, $task->id, $members);
                }
            }

            foreach ($new as $recipient) {
                $task_user = new TaskUser();
                $task_user->task_id = $task->id;
                $task_user->user_id = $recipient;

                try {
                    $task_user->save();

                    Notification::add(__('notification.new_member_task', ['task' => $task->title, 'member' => User::find($recipient)->getFullName()]), route('tasks'), $task->notification_type, $task->id, $recipients, false);

                } catch (QueryException $ex) {
                    Helper::logExceptionSql($ex);
                    return \Redirect::route('projects')->with('danger', __('project.new_member_ko'))->withInput();
                }
            }

            if ($hasChanges) {
                Notification::add($message, route('task', ['action'=>'detail','id'=>$task_id]), $task->notification_type, $task_id, $recipients, false);
            }

            return \Redirect::to($request->input('redirect_url'))->with('success', __('task.task_change_ok'))->withInput();

        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::to($request->input('redirect_url'))->with('danger', __('task.task_change_ko'))->withInput();
        }
    }

    public function delete(Request $request)
    {
        $task = Task::find($request->input('id'));
        if (is_null($task)) {
            return \Redirect::back()->with('danger', __('task.not_found'))->withInput();
        }

        if (\Auth::user()->isAdmin() || $task->user_id == \Auth::user()->id) {
            try {

                $task->delete();

                Notification::add(__('notification.delete_task', ['task' => $task->title]), route('tasks'), $task->notification_type, $task->id, $task->tasks_users->all());

                return \Redirect::back()->with('success', __('task.task_delete'))->withInput();

            } catch (QueryException $ex) {
                Helper::logExceptionSql($ex);
                return \Redirect::back()->with('danger', __('task.task_delete_ko'))->withInput();
            }
        } else {
            return \Redirect::back()->with('danger', __('auth.forbidden'))->withInput();
        }

    }
}
