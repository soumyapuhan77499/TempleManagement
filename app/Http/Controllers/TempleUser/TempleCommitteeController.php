<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TempleCommitteeController extends Controller
{
    //
    public function addnewcommittee(){
        return view('templeuser.add-temple-committee');
    }
    public function addsubcommittee(){
        return view('templeuser.add-temple-sub-committee');
    }
}
