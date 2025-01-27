<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
        'created_by',
        'text',
        'role',
        'blog_id',
        'reply',
    ];
}
