<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class followers extends Model
{
    protected $table = 'followers';
    public $timestamps = false;
    protected $fillable = ['follower_id', 'followee_id'];
}
