<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TempleBannerController extends Controller
{
    //
    public function addbanner(){
        return view('templeuser.add-temple-banner');
    }
}
