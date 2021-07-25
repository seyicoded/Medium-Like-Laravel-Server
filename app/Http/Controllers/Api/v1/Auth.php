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

    public function finalize_regis(Request $request){
        if($request->user_id == ''){
            return response()->json(['status'=> false, 'message' => "restart app"], 200);
        }
        if($request->state == ''){
            return response()->json(['status'=> false, 'message' => "state is required"], 200);
        }
        if($request->categories == ''){
            return response()->json(['status'=> false, 'message' => "categories are required"], 200);
        }

        $user_id = $request->user_id;
        $state = $request->state;
        $categories = $request->categories;

        $sql = "UPDATE users SET categories = ?, loc_state = ?, status = 1 WHERE u_id = ?";
        if( (DB::update($sql, [$categories, $state, $user_id])) != 0 ){
            $rec = DB::select("SELECT * from users where u_id = ? ", [$user_id]);
            return response()->json(['status'=> true, 'message' => "successfully", 'data'=> $rec[0]], 200);
        }else{
            return response()->json(['status'=> false, 'message' => "an error occurred"], 200);
        }
    }

    public function general_auth_otp(Request $request){
        TermiiSms::test();
    }

    public function user_information($id){
        $rec = DB::select("SELECT * from users where u_id = ? ", [$id]);
        return response()->json(['status'=> true, 'message' => "successfully", 'data'=> $rec], 200);
    }

    public function reg_push_token(Request $request){
        $device_token = $request->device_token;
        $device_type = $request->device_type;
        $account_mode = $request->account_mode;
        $account_id = $request->account_id;

        $data = DB::select('SELECT * from push_noti where device_token = ?', [$device_token]);
        if(count($data) == 0){
            //create new
            $sql = "INSERT INTO push_noti(account_mode,account_id,device_type,device_token) VALUES(?, ?, ?, ?)";
            if(DB::insert($sql, [$account_mode, $account_id, $device_type, $device_token])){
                return response()->json(['status'=>1, 'message'=>'token registered successfully',],200);
            }else{
                return response()->json(['status'=>0, 'message'=>'token probably registered before',],200);
            }
        }else{
            //update
            $sql = "UPDATE push_noti SET account_mode = ?, account_id = ?, device_type = ? WHERE device_token = ?";
            if( (DB::update($sql, [$account_mode, $account_id, $device_type, $device_token])) != 0 ){
                return response()->json(['status'=>1, 'message'=>'token updated successfully',],200);
            }else{
                return response()->json(['status'=>0, 'message'=>'token probably registered before',],200);
            }
        }
    }
}
