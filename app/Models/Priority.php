<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Priority
 *
 * @property int $id
 * @property string $priority Priority name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Priority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Priority wherePriority($value)
 * @mixin \Eloquent
 */
class Priority extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'priorities';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
