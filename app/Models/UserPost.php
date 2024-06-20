<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    use HasFactory;

    // If the table name is not the plural form of the model name, specify it explicitly
    protected $table = 'user_posts';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'post_name',
        'post_content',
        'post_tags',
        'post_owner',
        'timestamp'
    ];

    // If you are storing tags as JSON, cast the post_tags attribute to array
    // protected $casts = [
    //     'post_tags' => 'array',
    //     'timestamp' => 'datetime',
    // ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'post_owner');
    }
}
