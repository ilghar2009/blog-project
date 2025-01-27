<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'blog_id',
        'user_id',
        'quantity',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'user_id', 'user_id');
    }
}
