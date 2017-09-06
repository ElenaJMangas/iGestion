<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ProjectRequest;
use App\Models\Member;
use App\Models\Notification;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Member::whereUserId(\Auth::user()->id)->get();
        $status = array();
        $members = array();
        $project_tasks = array();
        $percentage = array();
        $example = false;

        if (count($projects) == 0) {
            $projects = Member::whereUserId(1)->get();
        }

        foreach ($projects as $project) {
            if ($project->project->id == 1) {
                $example = true;
            }
            $members[$project->project->id] = Member::whereProjectId($project->project->id)->get();
            $project_tasks[$project->project->id] = Task::whereProjectId($project->project->id)->get();

            if (count($project_tasks[$project->project->id]) == 0) {
                $status[$project->project->id][3] = 0;
            }

            foreach ($project_tasks[$project->project->id] as $task) {
                $status[$project->project->id][$task->status_id] = isset($status[$project->project->id][$task->status_id]) ? $status[$project->project->id][$task->status_id] + 1 : 1;
            }
        }

        foreach ($status as $key => $value) {
            $percentage[$key] = isset($value[3]) ? round($value[3] / count($value), 2) * 100 : 0;
        }

        $data = [
            'example' => $example,
            'projects' => $projects,
            'members' => $members,
            'tasks' => $project_tasks,
            'percentage' => $percentage
        ];

        return view('pages.projects', $data);
    }

    public function detail($project_id)
    {
        $project = Project::find($project_id);
        $projectTasks = Task::whereProjectId($project_id)->get();

        $status = array();
        $percentage = array();

        if (count($projectTasks) == 0) {
            $status[$project_id][3] = 0;
        }

        foreach ($projectTasks as $task) {

            $status[$project_id][$task->status_id] = isset($status[$project_id][$task->status_id]) ? $status[$project_id][$task->status_id] + 1 : 1;
        }

        foreach ($status as $key => $value) {
            $percentage[$key] = isset($value[3]) ? round($value[3] / count($value), 2) * 100 : 0;
        }

        $notifications = Notification::whereType($project->notification_type)->whereSourceId($project_id)->get()->sortByDesc('id');
        $output = Notification::collection($notifications);

        if (!\Auth::user()->isAdmin()) {
            $projectTasks = Task::whereProjectId($project_id)->with(array('tasks_users'=>function($query) use ($project_id){
                $query->whereUserId(\Auth::user()->id);
            }))->get();
        }

        $data = [
            'project' => $project,
            'percentage' => $percentage,
            'notifications' => $output,
            'example' => false,
            'projectTasks' => $projectTasks
        ];

        if (!is_null($project)) {
            return view('pages.project')->with($data);
        } else {
            return \Redirect::back()->with('danger', __('project.not_found'))->withInput();
        }
    }

    public function update($project_id = NULL)
    {
        $priorities = Priority::pluck('priority', 'id')->map(function ($item, $key) {
            return __('general.priorities.' . $item . '');
        });

        $project = (!is_null($project_id)) ? Project::find($project_id) : NULL;

        return view("pages.projectsform", compact('priorities'))->with('project', $project);
    }

    public function save(ProjectRequest $request, $project_id = NULL)
    {
        $newProject = true;

        // New project
        if (is_null($project_id)) {
            $project = new Project();
        } // Update project
        else {
            $newProject = false;
            $project = Project::find($project_id);
        }

        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->priority_id = $request->input('priority');

        if ($newProject) {
            $project->user_id = \Auth::user()->id;
        } else {
            $project->status_id = $request->input('status');
        }

        if (!$newProject) {
            $hasChanges = false;
            $changes = $project->getDirty();
            if (count($changes) > 0) {
                $hasChanges = true;
                foreach ($changes as $key => $value) {
                    $values[] = $project->getChanges($key, $value);
                }
                $values = implode(', ', $values);
                $message = __('notification.update_project', ['project' => $project->title, 'values' => $values]);
            }
        }

        try {
            $project->save();

            $new = $recipients = Helper::getRecipients();
            if (!$newProject) {
                $members = $project->members->all();

                foreach ($members as $member) {
                    if (in_array($member->user_id, $recipients)) {
                        unset($new[array_search($member->user_id, $new)]);
                    } else {
                        Member::whereUserId($member->user_id)->delete();
                        Notification::add(__('notification.delete_member_project', ['project' => $project->title, 'member' => User::find($member->user_id)->getFullName()]), route('project', $project_id), $project->notification_type, $project->id, $members);
                    }
                }
            }

            foreach ($new as $recipient) {
                $member = new Member();
                $member->project_id = $project->id;
                $member->user_id = $recipient;

                try {
                    $member->save();
                    if (!$newProject) {
                        Notification::add(__('notification.new_member_project', ['project' => $project->title, 'member' => User::find($recipient)->getFullName()]), route('projects'), $project->notification_type, $project->id, $recipients, false);
                    }

                } catch (QueryException $ex) {
                    Helper::logExceptionSql($ex);
                    return \Redirect::route('projects')->with('danger', __('project.new_member_ko'))->withInput();
                }

            }

            if ($newProject) {
                Notification::add(__('notification.new_project', ['project' => $project->title]), route('projects'), $project->notification_type, $project->id, $recipients, false);
            } else {
                if ($hasChanges) {
                    Notification::add($message, route('project', $project_id), $project->notification_type, $project_id, $recipients, false);
                }
            }

            if ($newProject) {
                return \Redirect::route('projects')->with('success', __('project.new_ok'))->withInput();
            } else {
                return \Redirect::route('project', $project_id)->with('success', __('project.change_ok'))->withInput();
            }


        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::route('projects')->with('danger', __('project.change_ko'))->withInput();
        }
    }

    public function members($id){
        $members = Member::whereProjectId($id)->with(array('user' => function($query){
            $query->select('id', \DB::raw("CONCAT(CONCAT(name,' '),surname) AS display_name"))->whereNotIn('id', [\Auth::user()->id, 1]);
        }))->get();

        $users = array();
        foreach ($members as $member){
            array_push($users,$member->user);
        }


        return json_encode(array_filter($users));
    }
}
