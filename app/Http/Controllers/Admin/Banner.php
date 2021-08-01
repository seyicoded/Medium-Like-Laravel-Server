<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\TermiiSms;
use Illuminate\Support\Facades\Validator;

class Banner extends Controller
{
    //

    public function view_banners(){
        $data = DB::select('SELECT * from banners ORDER BY b_id DESC', []);
        return view('Admin.Banners.View')->with('data', ['banners' => $data]);
    }

    public function create_banners(Request $request){
        if($request->company_name == ''){
            return 'company name is required';
        }
        if($request->company_image == ''){
            return 'company image is required';
        }

        $company_name = $request->company_name;
        $company_link = $request->company_link;
        $banners_image = $request->company_image;

        // update image
        //validate and move image
        $image_validator = Validator::make(['image' => $banners_image],['image' => 'mimes:jpeg,jpg,png,gif|required|max:10000']);
        if ($image_validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            //not an image
            return response()->json(['status'=>0, 'message'=>'not an image uploaded'],200);
        }

        $image_fileName = time().".".$banners_image->extension();

        if( !($banners_image->move(public_path('images/banners_image'),$image_fileName)) ){
            //error
            return response()->json(['status'=>0, 'message'=>'error uploading image'],200);
        }

        if( DB::insert('INSERT into banners (b_name, b_image, b_status, http_link) values (?, ?, ?, ?)', [$company_name, $image_fileName, 1, $company_link]) ){
            return back();
        }else{
            return back();
        }
    }

    public function toggle_banners(Request $request){
        if($request->b_id == ''){
            return back();
        }

        $b_id = $request->b_id;

        $b_status = DB::select('SELECT * from banners WHERE b_id = ?', [$b_id])[0]->b_status;

        $new_status = (intval($b_status) == 1) ? 0 : 1;

        DB::update('UPDATE banners set b_status = ? where b_id = ?', [$new_status, $b_id]);

        return back();

    }
}
