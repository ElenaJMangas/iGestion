<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\EventUser;
use App\Models\Member;
use App\Models\Reply;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $events = EventUser::whereUserId(\Auth::user()->id)->count();

        if (\Auth::user()->isAdmin()) {
            $comments = Comment::count();
            $replies = Reply::count();
            $totalComments = $comments + $replies;

            $members = User::whereNotIn('id',[1])->get();

            $tasks = Task::whereNotIn('id', [1])->orderBy('id','desc')->get();

            $monthTasks = Task::whereMonth('target_end_date',date('m'))->whereYear('target_end_date',date('Y'))->get();

            $data = [
                'totalComments' => $totalComments,
                'totalEvents' => $events,
                'totalMembers' => $members->count(),
                'members' => $members,
                'tasks' => $tasks->slice(0,5),
                'monthTasks' => $monthTasks
            ];

        } else {
            $totalTask = TaskUser::whereUserId(\Auth::user()->id)->count();

            $tasks = Task::whereHas('tasks_users',function ($query){
                $query->whereUserId(\Auth::user()->id);
            })->get();

            $totalProjects = Member::whereUserId(\Auth::user()->id)->count();
            $monthTasks = Task::whereHas('tasks_users',function ($query){
                $query->whereUserId(\Auth::user()->id);
            })->whereMonth('target_end_date',date('m'))->whereYear('target_end_date',date('Y'))->get();

            $data = [
                'totalTasks' => $totalTask,
                'totalEvents' => $events,
                'totalProjects' => $totalProjects,
                'tasks' => $tasks->slice(0,5),
                'monthTasks' => $monthTasks
            ];
        }

        return view("pages.".strtolower(\Auth::user()->getRole().".home"))->with($data);
    }
}
