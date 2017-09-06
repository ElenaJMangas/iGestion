<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Project
 *
 * @property int $id
 * @property int $user_id User owner
 * @property string $title Project Title
 * @property string $description Project Description
 * @property int|null $priority_id Project priority
 * @property int|null $status_id Project status 0 In progress | 1 Finished
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member[] $members
 * @property-read \App\Models\Priority|null $priority
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereUserId($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    public $notification_type = 1;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo('App\Models\Priority');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany('App\Models\Member');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        $status = ['in_progress', 'finished'];

        return $status[$this->status_id];
    }

    /**
     * @return string
     */
    public function getStatusColour()
    {
        $class = ['label-primary', 'label-success'];

        return $class[$this->status_id];
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
                return __("project.$key").": $value";
            case 'priority_id':
                $value = Priority::find($value);
                return __("general.priority").": ".__("general.priorities.".$value->priority);
            case 'status_id':
                return __("general.status").": ".__("project.".$this->getStatus());
            default:
                return "";
        }
    }
}
