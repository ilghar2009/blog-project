<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{

    protected $primaryKey = 'blog_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected
        $fillable=
        [
            'blog_id',
            'title',
            'text',
            'category_id',
            'created_by',
            'updated_by',
            'role',
        ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->blog_id = (string)Str::uuid();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

}
