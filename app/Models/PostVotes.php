<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property-read UserPost|null $post
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes query()
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property int $vote_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostVotes whereVoteType($value)
 * @mixin \Eloquent
 */
class PostVotes extends MainModel
{
    use HasFactory;

    protected $table = 'post_votes';

    protected $fillable = [
        'user_id',
        'post_id',
        'vote_type',
    ];

    /**
     * Get the user that owns the vote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that owns the vote.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(UserPost::class, 'post_id');
    }
}
