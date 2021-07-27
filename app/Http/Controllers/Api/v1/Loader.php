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
}
