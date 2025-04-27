<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile');
    }
    public function like()
    {
        return $this->belongsTo('App\Models\Like');
    }

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment');
    }

    public function soldItem()
    {
        return $this->belongsTo('App\Models\SoldItem');
    }
}
