<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Auth extends Controller
{
    //this controller would be responsible for auth from app

    public function universal_login(Request $request){
        echo "reach";
    }

    public function general_auth_otp(Request $request){

    }
}
