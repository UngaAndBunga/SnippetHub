<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $tag_id
 * @property int $post_id
 * @property-read UserPost $post
 * @property-read Tags|null $tag
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostTags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostTags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostTags query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostTags wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostTags whereTagId($value)
 *
 * @mixin \Eloquent
 */
class PostTags extends MainModel
{
    use HasFactory;

    protected $table = 'post_tags';

    protected $fillable = [
        'post_id',
        'tag_id',
    ];

    public $timestamps = false;

    public function post(): BelongsTo
    {
        return $this->belongsTo(UserPost::class, 'post_id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(tags::class, 'id');
    }
}
