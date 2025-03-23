<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $post_name
 * @property string $post_content
 * @property int $post_owner
 * @property string $timestamp
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read Collection<int, PostTags> $postTags
 * @property-read int|null $post_tags_count
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost wherePostContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost wherePostOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPost whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class UserPost extends MainModel
{
    use HasFactory;

    protected $table = 'user_posts';

    protected $fillable = [
        'post_name',
        'post_content',
        'post_owner',
        'timestamp',
    ];

    public static int $ttl = 60;

    public $timestamps = false;

    public function postTags(): HasMany
    {
        return $this->hasMany(postTags::class, 'post_id');

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'post_owner');
    }
}
