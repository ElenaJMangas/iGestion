<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Notification;
use App\Models\Reply;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function add(Request $request, $comment_id)
    {
        $comment = new Reply();

        $comment->comment_id = $comment_id;
        $comment->user_id = \Auth::user()->id;
        $comment->comment = $request->input('reply');

        try {
            $comment->save();

            Notification::add(__('notification.new_reply', ['project' => $comment->commentFather->project->title, 'reply' => $comment->comment, 'comment' => $comment->commentFather->comment]), route('project', $comment->commentFather->project->id), $comment->commentFather->project->notification_type, $comment->commentFather->project->id, $comment->commentFather->project->members->all());

            return \Redirect::back();
        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::back()->with('danger', __('project.reply_ko'))->withInput();
        }
    }

    public function delete($comment_id)
    {
        $comment = Reply::findOrFail($comment_id);

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
