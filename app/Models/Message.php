<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $user_id From User id
 * @property string $subject Subject
 * @property string $message Message
 * @property int|null $status Message Status 0 Draft | 1 Sent | 2 Deleted
 * @property \Carbon\Carbon|null $date_sent Date sent
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereDateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUserId($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_sent'
    ];

    public $notification_type = 4;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getShortBody($limit = 50)
    {
        $str = str_replace(['<p>', '</p>'], ["", ". "], $this->message);
        $stripTag = strip_tags($str);
        return str_limit($stripTag, $limit);
    }

    public function getTimeAgo()
    {
        if(!is_null($this->date_sent)){
            return $this->date_sent->diffForHumans();
        }
    }

    public function authorize()
    {
        if ($this->user_id == \Auth::user()->id) {
            return true;
        } else {
            $users = MessageReceiver::whereUserId(\Auth::user()->id)->whereMessageId($this->id)->first();
            if (is_null($users)) {
                return false;
            } else {
                return true;
            }
        }
    }
}
