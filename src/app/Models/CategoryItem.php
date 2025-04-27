<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function category()
    {
        return $this->hasMany('App\Models\Category');
    }
}
