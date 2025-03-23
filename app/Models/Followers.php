<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * 
 *
 * @method static Builder<static>|Followers newModelQuery()
 * @method static Builder<static>|Followers newQuery()
 * @method static Builder<static>|Followers query()
 * @property int $follower_id
 * @property int $followee_id
 * @method static Builder<static>|Followers whereFolloweeId($value)
 * @method static Builder<static>|Followers whereFollowerId($value)
 * @mixin \Eloquent
 */
class Followers extends MainModel
{
    protected $table = 'user_followers';

    public $timestamps = false;
    protected $fillable = [
        'follower_id',
        'followee_id',
    ];
}
