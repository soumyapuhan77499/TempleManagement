<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TempleDonationController extends Controller
{
    //
    public function adddonation(){
        return view('templeuser.add-temple-donation');
    }
}
