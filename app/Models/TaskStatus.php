<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaskStatus
 *
 * @property int $id
 * @property string $status Task status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TaskStatus whereStatus($value)
 * @mixin \Eloquent
 */
class TaskStatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'status',
    ];

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
    public function getColourStatus()
    {
        return strtolower(str_replace(' ','',$this->status));
    }
}
