<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CompteController extends Controller
{
    /*
    ===========================================================================
        Ce controlleur servira :
            - Pour la gestion du compte de User, Admin :
                Pour User :

                Pour Admin :
                    = admin_index()
    ===========================================================================
    */

    /*
    ========================
        Codes pour Admin :
    ========================
    */
    
    public function admin_index(){
        return view('admin.admin_index');
    }
}
