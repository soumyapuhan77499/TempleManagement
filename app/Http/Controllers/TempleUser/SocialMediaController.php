<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    //
    public function socialmedia(){
        return view('templeuser.addsocialmedia');
    }
}
