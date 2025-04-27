<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'brand',
        'description',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function condition()
    {
        return $this->hasOne('App\Models\condition');
    }
}