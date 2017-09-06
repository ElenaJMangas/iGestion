<?php

namespace App\Models;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $notification Notification description
 * @property string $action Notification url
 * @property int|null $type Notification Type 0 General | 1 Projects | 2 Tasks | 3 Events | 4 Messages
 * @property int|null $source_id Notification source
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationUser[] $notifications_user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification withoutTrashed()
 * @mixin \Eloquent
 */
class Notification extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications_user()
    {
        return $this->hasMany('App\Models\NotificationUser', 'notification_id');
    }

    /**
     * @param string $notification
     * @param string $action
     * @param int|null $type
     * @param int|null $source_id
     * @param EventUser[] $recipients
     * @param bool $multiple
     * @return void
     */
    public static function add($notification, $action, $type, $source_id, $recipients, $multiple = true)
    {
        $objNotification = new Notification();
        $objNotification->notification = $notification;
        $objNotification->action = $action;
        $objNotification->type = $type;
        $objNotification->source_id = $source_id;

        try {
            $objNotification->save();

            foreach ($recipients as $recipient) {
                $user = new NotificationUser();
                $user->user_id = ($multiple) ? $recipient->user_id : $recipient;
                $user->notification_id = $objNotification->id;

                $user->save();
            }
        } catch (QueryException $ex) {
            Helper::logExceptionSql($ex);
        }
    }

    /**
     * @param Notification[] $notifications
     * @param bool $general
     * @return array
     */
    public static function collection($notifications, $general = false)
    {
        $output = array();

        foreach ($notifications as $notification) {
            $output[Helper::formatDateWithoutHour($notification->created_at)][] = (!$general) ? $notification : $notification->notification;
        }
        return $output;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        $icons = ['bg-yellow fa-user', 'bg-green fa-briefcase', 'bg-red fa-tasks', 'bg-blue fa-calendar', 'bg-teal fa-envelope-o'];

        return $icons[$this->type];
    }

    /**
     * @param NotificationUser[] $notifications
     */
    public static function setRead($notifications)
    {
        foreach ($notifications as $notification) {
            $notification->notification->read_at = Carbon::now();
            $notification->notification->save();
        }
    }

    /**
     * @return int
     */
    public static function getNotRead()
    {
        $notifications = NotificationUser::whereReadAt(null)->whereUserId(\Auth::user()->id);
        return $notifications->count();
    }

    public static function getList()
    {
        return NotificationUser::whereReadAt(null)
            ->whereUserId(\Auth::user()->id)
            ->with('notification')
            ->get()
            ->sortByDesc('notification_id');
    }
}
