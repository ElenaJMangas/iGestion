<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NotificationUser
 *
 * @property int $user_id User ID
 * @property int $notification_id Notification ID
 * @property string|null $read_at Read at date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Notification $notification
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationUser whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationUser whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationUser whereUserId($value)
 * @mixin \Eloquent
 */
class NotificationUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications_users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notification() {
        return $this->belongsTo('App\Models\Notification');
    }
}
