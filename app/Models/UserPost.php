<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPost extends Model
{
    use HasFactory;

    protected $table = 'user_posts';

    protected $fillable = [
        'post_name',
        'post_content',
        'post_owner',
        'timestamp'
    ];
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
