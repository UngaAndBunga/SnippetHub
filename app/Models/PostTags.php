<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    use HasFactory;
    protected $table = 'post_tags';

    protected $fillable = [
        'post_id',
        'tag_id'

    ];
    public $timestamps = false;
    public function post()
    {
        return $this->belongsTo(UserPost::class, 'post_id');
    }

    public function tag()
    {
        return $this->belongsTo(tags::class, 'id');
    }
}
