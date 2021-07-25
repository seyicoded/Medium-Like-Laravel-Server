<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\TermiiSms;
use Illuminate\Support\Facades\DB;

class Auth extends Controller
{
    //this controller would be responsible for auth from app

    public function auth_user_in(Request $request){
        if($request->email == ''){
            return response()->json(['status'=> false, 'message' => "email is required"], 200);
        }

        if($request->name == ''){
            return response()->json(['status'=> false, 'message' => "email is required"], 200);
        }

        $email = strtolower($request->email);
        $name = strtolower($request->name);
        $photo_url = ($request->photo_url != '') ? $request->photo_url: '';

        // check if record exist
        $rec = DB::select("SELECT * from users where email = ? && name LIKE ?", [$email, "%$name%"]);
        if( count($rec) != 0 ){
            // exist
            // check if account is completed
            if( intval($rec[0]->status) == 1 ){
                // completed
                return response()->json(['status'=> true, 'message' => "successfully", 'data'=> $rec[0]], 200);
            }else if( intval($rec[0]->status) == 0 ){
                // not-completed
                return response()->json(['status'=> false, 'type' => "not-completed", 'message' => "not completed", 'data'=> $rec[0]], 200);
            }else{
                // account blocked
                return response()->json(['status'=> false, 'type' => "suspended", 'message' => "account suspended"], 200);
            }
        }else{
            // doesn't exist

            $sql = "INSERT INTO users(email, name, photo_url, status) VALUES(?, ?, ?, 0)";
            if( (DB::insert($sql, [$email, $name, $photo_url])) ){
                // get data
                $rec = DB::select('SELECT * from users where email = ? && name = ?', [$email, $name]);
                return response()->json(['status'=> false, 'type' => "not-completed", 'message' => "not completed", 'data'=> $rec[0]], 200);
            }else{
                return response()->json(['status'=> false, 'type' => "not-found", 'message' => "account not found, already exist but different name"], 200);
            }

        }
    }

    public function get_all_categories(Request $request){
        $rec = DB::select('SELECT * from categories ORDER BY c_id DESC', []);
        return response()->json(['status'=> true, 'message' => "loaded successfully", 'data'=> $rec], 200);
    }

    public function general_auth_otp(Request $request){
        TermiiSms::test();
    }
}
