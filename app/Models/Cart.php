<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{

    protected $primaryKey = 'carts_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
            'carts_id',
            'user_id',
        ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->carts_id = (string)Str::uuid();
        });
    }
}
