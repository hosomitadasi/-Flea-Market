<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'brand',
        'description',
        'image_url',
        'user_id',
        'condition_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function condition()
    {
        return $this->belongsTo('App\Models\Condition');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function soldItem()
    {
        return $this->hasOne('App\Models\SoldItem');
    }

    public function categoryItem()
    {
        return $this->hasMany('App\Models\CategoryItem');
    }
}