<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterdUserController extends Controller
{
    public function showMypageForm()
    {
        return view('mypage');
    }

    public function showProfileForm()
    {
        return view('profile');
    }
}
