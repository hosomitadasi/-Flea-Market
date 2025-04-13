<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function showSellForm()
    {
        return view('sell');
    }

    public function showPurchaseForm()
    {
        return view('purchase');
    }

    public function showAddressForm()
    {
        return view('address');
    }
}
