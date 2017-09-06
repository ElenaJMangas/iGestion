<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $title Event Title
 * @property string|null $description Event Description
 * @property int|null $all_day All day event disable/enable (0/1)
 * @property int|null $legend_id Legend
 * @property string|null $start_date Start date
 * @property string|null $end_date End date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventUser[] $events_user
 * @property-read \App\Models\Legend|null $legend
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member[] $recipients
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereAllDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereLegendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event withoutTrashed()
 * @mixin \Eloquent
 */
class Event extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public $notification_type = 3;

    protected static function boot() {
        parent::boot();

        static::deleting(function($event) {
            $event->events_user()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function legend() {
        return $this->belongsTo('App\Models\Legend');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients() {
        return $this->hasMany('App\Models\Member');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events_user()
    {
        return $this->hasMany('App\Models\EventUser', 'event_id');
    }

    /**
     * @param string $key
     * @param string $value
     * @return string
     */
    public function getChanges($key, $value)
    {
        switch ($key) {
            case 'title':
            case 'description':
                return __("event.$key").": $value";
            case 'all_day':
                return __("event.$key").": ".($value == 1) ? __('general.enabled') : __('general.disabled');
            case 'start_date':
            case 'end_date':
                return __("event.$key").": ".Helper::formatDate($value);
            default:
                return "";
        }
    }
}
