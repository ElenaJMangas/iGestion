<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Notification;
use App\Models\Comment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function add(Request $request, $project_id)
    {
        $comment = new Comment();

        $comment->user_id = \Auth::user()->id;
        $comment->project_id = $project_id;
        $comment->comment = $request->input('comment');

        try {
            $comment->save();

            Notification::add(__('notification.new_comment', ['project' => $comment->project->title, 'comment' => $comment->comment]), route('project', $project_id), $comment->project->notification_type, $comment->project->id, $comment->project->members->all());
            return \Redirect::back();
        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::back()->with('danger', __('project.change_ko'))->withInput();
        }
    }

    public function delete($comment_id){
        $comment = Comment::findOrFail($comment_id);

        $success = false;
        if (\Auth::user()->isAdmin() || $comment->user_id == \Auth::user()->id) {
            $success = true;
        }

        if ($success) {
            try {
                $comment->delete();

                return \Redirect::back();

            } catch (QueryException $ex) {
                Helper::logExceptionSql($ex);
                return \Redirect::back()->with('danger', __('project.comment_delete_ko'))->withInput();
            }
        } else {
            return \Redirect::back()->with('danger', __('auth.forbidden'))->withInput();
        }
    }
}
