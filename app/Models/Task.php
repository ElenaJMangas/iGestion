<?php

namespace App\Models;

use App\Helpers\Helper;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property int $user_id User owner
 * @property string $title Task Title
 * @property string $description Task Description
 * @property int|null $priority_id Task priority
 * @property int $status_id Task status
 * @property int|null $done_user_id User that done the task
 * @property int|null $project_id Project owner
 * @property string|null $target_end_date Task target end date
 * @property string|null $actual_end_date Task actual end date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Models\Priority|null $priority
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\TaskStatus $tasks_status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaskUser[] $tasks_users
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Task onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereActualEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereDoneUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereTargetEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Task withoutTrashed()
 * @mixin \Eloquent
 */
class Task extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority_id',
        'status_id',
    ];

    public $notification_type = 2;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($event) {
            $event->tasks_users()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo('App\Models\Priority', 'priority_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tasks_status()
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks_users()
    {
        return $this->hasMany('App\Models\TaskUser', 'task_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    /**
     * @return array
     */
    public function getTaskCompletion()
    {
        $result = ($this->status_id != 3) ? $this->DaysLeft() : $this->getElapsedDays();

        return $result;
    }

    /**
     * @return string
     */
    public function getTargetEndDate()
    {
        $result = '';
        if (!empty($this->target_end_date)) {
            $date = new DateTime($this->target_end_date);
            $result = $date->format(Helper::setFormatDate() . ' H:i');
        }
        return $result;

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
                return __("task.$key") . ": $value";
            case 'priority_id':
                $value = Priority::find($value);
                return __("general.priority") . ": " . __("general.priorities." . $value->priority);
            case 'status_id':
                $value = TaskStatus::find($value);
                return __("general.status") . ": " . __("task." . $value->status);
            case 'done_user_id':
                $value = $this->updated_at;
                return __("general.date") . ": " . Helper::formatDate($value);
            case 'target_end_date':
                return __("task.$key") . ": " . Helper::formatDate($value);
            default:
                return "";
        }
    }

    /**
     * @return int
     */
    private function getElapsedDays()
    {
        $result = array();

        $targetEndDate = new DateTime($this->target_end_date);
        $actualEndDate = new DateTime($this->actual_end_date);

        $interval = $targetEndDate->diff($actualEndDate);
        $days = (int)$interval->format('%R%a');

        if ($days < 0) {
            $result['success'] = true;
        } else {
            $result['success'] = false;
        }

        $result['days'] = abs($days);
        $result['finished'] = true;

        return $result;
    }

    /**
     * @return array
     */
    private function DaysLeft()
    {
        $result = array();

        $now = new DateTime();
        $targetEndDate = new DateTime($this->target_end_date);
        $interval = $now->diff($targetEndDate);
        $days = (int)$interval->format('%R%a');

        if ($days < 0) {
            $result['success'] = false;
        } else {
            $result['success'] = true;
        }

        $result['days'] = ($days);
        $result['finished'] = false;

        return $result;
    }
}
