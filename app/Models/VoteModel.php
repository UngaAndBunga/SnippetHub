<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteModel extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the plural of the model name
    protected $table = 'votes';

    // Specify which attributes can be mass assignable
    protected $fillable = [
        'user_id',
        'post_id',
        'vote_type',
    ];

    /**
     * Get the user that owns the vote.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that owns the vote.
     */
    public function post()
    {
        return $this->belongsTo(UserPost::class, 'post_id');
    }
}
