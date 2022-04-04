<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /*
    ====================================================================
        Ce controlleur serviva de controlleur general (non specifique)
            - pageIndex()
    ====================================================================
    */

    public function pageIndex(){
        return view('index');
    }
}
