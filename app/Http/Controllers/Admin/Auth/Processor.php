<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Processor extends Controller
{
    //

    public function load_login(){
        return view('Guest.Login');
    }

    public function login_processor(Request $request){
        if($request->email == ''){
            return 'admin email is required';
        }
        if($request->password == ''){
            return 'admin password is required';
        }

        $email = $request->email;
        $passwrod = md5($request->password);

        $data = DB::select('SELECT * from admin_info where email = ? && password = ?', [$email, $passwrod]);

        if(count($data) == 0){
            return "account not found";
        }

        setcookie(sha1('admin_logged_in'), sha1('true'), time() + (86400 * 365), "/");
        setcookie(sha1('admin_id'), base64_encode($data[0]->a_id), time() + (86400 * 365), "/");

        return redirect(url('/admin'));
    }

    public function logout(){
        setcookie(sha1('admin_logged_in'), '', time() - (86400 * 765), "/");
        setcookie(sha1('admin_id'), '', time() - (86400 * 765), "/");
        return redirect(url('/admin/login'));
    }
}
