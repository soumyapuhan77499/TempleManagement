<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TempleRequestController extends Controller
{
    //
    public function templerequests(){
        return view('superadmin.temple_requests');
    }
}
