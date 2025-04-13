<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function showIndexForm()
    {
        return view('index');
    }

    public function showDetailForm()
    {
        return view('detail');
    }
}
