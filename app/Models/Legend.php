<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Legend
 *
 * @property int $id
 * @property string $colour Colour legend
 * @property string $category Category legend
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Legend whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Legend whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Legend whereId($value)
 * @mixin \Eloquent
 */
class Legend extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'legend';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }
}
