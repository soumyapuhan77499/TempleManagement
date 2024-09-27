<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplePrasadController extends Controller
{
    //
    public function addPrasad(){
        return view('templeuser.add-temple-prasad');
    }
}
