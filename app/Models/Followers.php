<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder<static>|Followers newModelQuery()
 * @method static Builder<static>|Followers newQuery()
 * @method static Builder<static>|Followers query()
 *
 * @mixin \Eloquent
 */
class Followers extends MainModel
{
    protected $table = 'followers';

    protected $fillable = [
        'follower_id',
        'followee_id',
    ];
}
