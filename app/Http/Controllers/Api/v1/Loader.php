<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Loader extends Controller
{
    //
    public function get_home_info(Request $request){
        if($request->user_id == ''){
            return response()->json(['status'=> false, 'message' => "restart app"], 200);
        }

        $user_id = $request->user_id;

        // get categories subscribed
        $cat = DB::select('SELECT * from users where u_id = ?', [$user_id])[0]->categories;
        $cat_arr = explode(",", $cat);

        $where = '';
        $num = count($cat_arr);
        for ($i = 1 ; $i <= $num ; $i++ ) {
            if( ($i == 1) ){
                $where = $where."c_id = ".$cat_arr[$i-1]." ||";
            }else if( $i == $num ){
                $where = $where."c_id = ".$cat_arr[$i-1];
            }else{
                $where = $where."c_id = ".$cat_arr[$i-1]. "||";
            }
        }

        $cat_data = DB::select('SELECT * from categories where '.$where, []);
        // get all article of categories subscribed
        $article_data = DB::select('SELECT * from articles where '.$where." ORDER BY a_id DESC", []);

        return response()->json(['status'=> true, 'message' => "loaded", 'categories'=> $cat_data, 'articles'=>$article_data], 200);
    }

    public function get_home_info_single(Request $request){
        if($request->user_id == ''){
            return response()->json(['status'=> false, 'message' => "restart app"], 200);
        }
        if($request->c_id == ''){
            return response()->json(['status'=> false, 'message' => "restart app"], 200);
        }

        $user_id = $request->user_id;
        $c_id = $request->c_id;

        // // get categories subscribed
        // $cat = DB::select('SELECT * from users where u_id = ?', [$user_id])[0]->categories;
        // $cat_arr = explode(",", $cat);

        // $where = '';
        // $num = count($cat_arr);
        // for ($i = 1 ; $i <= $num ; $i++ ) {
        //     if( ($i == 1) ){
        //         $where = $where."c_id = ".$cat_arr[$i-1]." ||";
        //     }else if( $i == $num ){
        //         $where = $where."c_id = ".$cat_arr[$i-1];
        //     }else{
        //         $where = $where."c_id = ".$cat_arr[$i-1]. "||";
        //     }
        // }

        // $cat_data = DB::select('SELECT * from categories where '.$where, []);
        // get all article of categories subscribed
        $article_data = DB::select('SELECT * from articles where c_id = ? ORDER BY a_id DESC', [$c_id]);

        return response()->json(['status'=> true, 'message' => "loaded", 'articles'=>$article_data], 200);
    }

    public function get_home_info_search(Request $request){
        if($request->user_id == ''){
            return response()->json(['status'=> false, 'message' => "restart app"], 200);
        }
        if($request->search == ''){
            return response()->json(['status'=> false, 'message' => "restart app"], 200);
        }

        $user_id = $request->user_id;
        $search = $request->search;

        $article_data = DB::select('SELECT * from articles where a_title LIKE ? OR a_desc LIKE ? OR a_content LIKE ? ORDER BY a_id DESC', ["%$search%", "%$search%", "%$search%"]);

        return response()->json(['status'=> true, 'message' => "loaded", 'articles'=>$article_data], 200);
    }

    public function sub_toggler(Request $request){
        if($request->user_id == ''){
            return response()->json(['status'=> false, 'message' => "restart app 1"], 200);
        }
        if($request->hasCat_already == ''){
            return response()->json(['status'=> false, 'message' => "restart app 2"], 200);
        }
        if($request->c_id == ''){
            return response()->json(['status'=> false, 'message' => "restart app 3"], 200);
        }

        $user_id = $request->user_id;
        $hasCat_already = $request->hasCat_already;
        $c_id = $request->c_id;

        $present_cat = (DB::select('SELECT * from users where u_id = ?', [$user_id]))[0]->categories;

        if($hasCat_already){
            // code to un-subscribe
            // we need to loop it and un-link d un-subscribed one

            $cat_arr = explode(",", $present_cat);

            $new_cat = '';
            $num = count($cat_arr);
            for ($i = 1 ; $i <= $num ; $i++ ) {
                if($cat_arr[$i-1] == $c_id){
                    continue;
                }

                if( ($i == 1) ){
                    $new_cat = $new_cat.$cat_arr[$i-1].",";
                }else if( $i == $num ){
                    $new_cat = $new_cat.$cat_arr[$i-1];
                }else{
                    $new_cat = $new_cat.$cat_arr[$i-1]. ",";
                }
            }
            // check for excess: ,
            if(str_ends_with($new_cat, ',')){
                $str_l = strlen($new_cat);
                $new_cat = substr($new_cat, 0, intval($str_l) - 1);
            }

            if( (DB::update('UPDATE users set categories = ? where u_id = ?', [$new_cat, $user_id])) != 0 ){
                return response()->json(['status'=> true, 'message' => "successfully subscribed"], 200);
            }else{
                return response()->json(['status'=> false, 'message' => "an error occurred"], 200);
            }

        }else{
            // code to subscribe
            $new_cat = $present_cat.",$c_id";
            if( (DB::update('UPDATE users set categories = ? where u_id = ?', [$new_cat, $user_id])) != 0 ){
                return response()->json(['status'=> true, 'message' => "successfully subscribed"], 200);
            }else{
                return response()->json(['status'=> false, 'message' => "an error occurred"], 200);
            }
        }
    }
}
