<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\MessageReceiver;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MessagesController extends Controller
{

    const FOLDER_INBOX = 'inbox';
    const FOLDER_SENT = 'sent';
    const FOLDER_DRAFTS = 'draft';
    const FOLDER_TRASH = 'trash';

    protected $status_draft = 0;
    protected $status_sent = 1;
    protected $status_trash = 2;

    public function index()
    {
        $inbox = MessageReceiver::whereUserId(\Auth::user()->id)->whereRead(false)->whereHas('message', function ($query) {
            $query->whereStatus($this->status_sent);
        })->count();

        $drafts = Message::whereUserId(\Auth::user()->id)->whereStatus(false)->count();

        $data = [
            'inbox' => $inbox,
            'drafts' => $drafts
        ];

        return view("pages.messages", $data);
    }

    public function getMessages($folder)
    {
        $messages = array();
        switch ($folder) {
            case self::FOLDER_INBOX:

                $messages_receiver = MessageReceiver::whereUserId(\Auth::user()->id)->whereHas('message', function ($query) {
                    $query->whereStatus($this->status_sent)->orderBy('date_sent', 'desc');
                })->get();

                foreach ($messages_receiver as $message) {
                    $messages[] = $message->message;
                }

                break;
            case self::FOLDER_SENT:
                $messages = Message::whereUserId(\Auth::user()->id)->whereStatus($this->status_sent)->orderBy('date_sent', 'desc')->get();
                break;
            case self::FOLDER_DRAFTS:
                $messages = Message::whereUserId(\Auth::user()->id)->whereStatus($this->status_draft)->orderBy('date_sent', 'desc')->get();
                break;
            case self::FOLDER_TRASH:
                $message_sent = Message::whereUserId(\Auth::user()->id)->whereStatus($this->status_trash)->orderBy('date_sent', 'desc')->get();
                $messages_receiver = MessageReceiver::whereUserId(\Auth::user()->id)->whereHas('message', function ($query) {
                    $query->whereStatus($this->status_trash)->orderBy('id', 'desc');
                })->get();

                foreach ($messages_receiver as $message) {
                    $messages[] = $message->message;
                }

                $messages = $message_sent->union($messages);
                break;
            default:
                break;
        }

        $json = array();
        foreach ($messages as $message) {
            $json[] = [
                '<input id="' . $message->id . '" type="checkbox">',
                '<a href="' . route('message', $message->id) . '">' . $message->user->getFullName() . '</a>',
                "<b>" . $message->subject . "</b> - " . $message->getShortBody(),
                $message->getTimeAgo()
            ];
        }

        return $json;
    }

    public function send(MessageRequest $request)
    {
        if ($request->input('draft') == 1) {
            $message = Message::find($request->input('message_id'));
        } else {
            $message = new Message();
        }

        $message->user_id = \Auth::user()->id;
        $message->subject = $request->input('subject');
        $message->message = $request->input('message');
        $message->status = $this->status_sent;
        $message->date_sent = Carbon::now();

        try {
            $message->save();

            $recipients = Helper::getRecipients(false);
            foreach ($recipients as $recipient) {
                $message_receiver = new MessageReceiver();
                $message_receiver->message_id = $message->id;
                $message_receiver->user_id = $recipient;
                $message_receiver->save();
            }

            Notification::add(__('notification.send_message', ['message' => $message->getShortBody()]), route('messages'), $message->notification_type, $message->id, $recipients, false);

            return \Redirect::route('messages')->with('success', __('general.message.sent'))->withInput();
        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::route('messages')->with('danger', __('general.message.notSent'))->withInput();
        }

    }

    public function compose()
    {
        return view("pages.compose");
    }

    public function detail($id)
    {
        $message = Message::find($id);

        if (is_null($message)) {
            return \Redirect::route('messages')->with('danger', __('general.message.not_found'))->withInput();
        }

        if ($message->authorize() == false) {
            return \Redirect::route('messages')->with('danger', __('auth.forbidden'))->withInput();
        }

        if ($message->status == $this->status_draft) {
            return view("pages.compose", ['message' => $message]);
        }

        if (($message->user_id != \Auth::user()->id &&  $this->setRead($id)) || $message->user_id == \Auth::user()->id) {
            return view("pages.message", ['message' => $message]);
        } else {
            return \Redirect::route('messages')->with('danger', __('auth.forbidden'))->withInput();
        }
    }

    public function reply(Request $request)
    {
        $id = $request->input('message_id');
        if (!is_null($id)) {
            $message = Message::find($id);

            if (is_null($message)) {
                return \Redirect::route('messages')->with('danger', __('general.message.not_found'))->withInput();
            }

            if ($message->authorize() == false) {
                return \Redirect::route('messages')->with('danger', __('auth.forbidden'))->withInput();
            }

            return view("pages.compose", ['message' => $message]);
        } else {
            return \Redirect::route('messages')->with('danger', __('general.message.not_found'))->withInput();
        }
    }

    public function draft(Request $request)
    {
        if ($request->input('draft') == 1) {
            $message = Message::find($request->input('message_id'));
        } else {
            $message = new Message();
        }
        $message->user_id = \Auth::user()->id;
        $message->subject = $request->input('subject');
        $message->message = $request->input('message');
        $message->status = $this->status_draft;

        try {
            $message->save();

            return \Redirect::route('messages')->with('success', __('general.message.drafted'))->withInput();
        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
            return \Redirect::route('messages')->with('danger', __('general.message.notDraft'))->withInput();
        }
    }

    public function delete(Request $request)
    {
        $success = true;

        $ids = $request->input('delete');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $message = Message::find($id);
                $message->status = $this->status_trash;
                try {
                    $message->save();
                } catch (QueryException $exception) {
                    $success = false;
                }
            }
        }

        if ($success) {
            return \Redirect::route('messages')->with('success', __('general.message.deleted'))->withInput();
        } else {
            return \Redirect::route('messages')->with('danger', __('general.message.notDeleted'))->withInput();
        }
    }

    private function setRead($id)
    {
        $message_receiver = MessageReceiver::whereUserId(\Auth::user()->id)->whereMessageId($id)->first();

        if (is_null($message_receiver)) {
            return false;
        }

        if ($message_receiver->read == 0) {
            $message_receiver->read = 1;
            try {
                $message_receiver->save();
                return true;
            } catch (QueryException $ex) {
                Helper::logExceptionSql($ex);
                return false;
            }
        } else {
            return true;
        }

    }
}
