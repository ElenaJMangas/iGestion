<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationUser;
use Carbon\Carbon;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications_user = NotificationUser::whereUserId(\Auth::user()->id);
        $output = $notifications_user->with('notification')->get()->sortByDesc('notification_id');
        $notifications_user->update(['read_at' => Carbon::now()]);
        $notifications = Notification::collection($output, true);

        return view('pages.notifications')->with('notifications', $notifications);
    }

    public function getNotRead()
    {
        return Notification::getNotRead();
    }

    public function viewGetList()
    {
        return view('partials.notifications')->render();
    }

    public function read($id)
    {
        NotificationUser::whereNotificationId($id)->whereUserId(\Auth::user()->id)->update(['read_at' => Carbon::now()]);
        $notification = NotificationUser::whereNotificationId($id)->whereUserId(\Auth::user()->id)->first();

        return \Redirect::to($notification->notification->action);
    }
}
