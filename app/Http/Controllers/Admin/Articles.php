<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\TermiiSms;
use Illuminate\Support\Facades\Validator;

class Articles extends Controller
{
    //

    public function create_article(Request $request){
        $categories_data = DB::select('SELECT * from categories ORDER BY c_id DESC', []);
        return view('Admin.Article.Create')->with('data', ['categories_data'=> $categories_data, 'all_states' => TermiiSms::get_all_state()]);
    }

    public function create_article_now(Request $request){
        if($request->article_title == ''){
            return 'article title is required';
        }
        if($request->category_id == ''){
            return 'category is required';
        }
        if($request->article_desc == ''){
            return 'article desc is required';
        }
        if($request->p_content == ''){
            return 'article content is required';
        }
        if($request->article_image == ''){
            return 'article image is required';
        }
        if($request->article_location == ''){
            return 'article location is required';
        }
        if($request->bb_text == ''){
            return 'bottom button text is required';
        }
        if($request->bb_link == ''){
            return 'bottom button link is required';
        }

        $article_title = $request->article_title;
        $category_id = $request->category_id;
        $article_desc = $request->article_desc;
        $p_content = $request->p_content;
        $article_image = $request->article_image;
        $article_location = strtoupper($request->article_location);
        $bb_text = $request->bb_text;
        $bb_link = $request->bb_link;

        // update image
        //validate and move image
        $image_validator = Validator::make(['image' => $article_image],['image' => 'mimes:jpeg,jpg,png,gif|required|max:10000']);
        if ($image_validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            //not an image
            return response()->json(['status'=>0, 'message'=>'not an image uploaded'],200);
        }

        $image_fileName = time().".".$article_image->extension();

        if( !($article_image->move(public_path('images/article_image'),$image_fileName)) ){
            //error
            return response()->json(['status'=>0, 'message'=>'error uploading image'],200);
        }

        $sql = "INSERT INTO articles(c_id, a_title, a_desc, a_content, a_image, a_location, a_status, bottom_button_link, bottom_button_text) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if( (DB::insert($sql, [$category_id, $article_title, $article_desc, $p_content, $image_fileName, $article_location, 1, $bb_link, $bb_text])) ){
            TermiiSms::send_notification_from_article_created( (DB::select('SELECT * from articles where c_id = ? AND a_content = ? AND a_title = ?', [$category_id, $p_content, $article_title]))[0] );
            return redirect(url('/admin/view-articles'));
        }else{
            return "an error occurred";
        }
    }

    public function view_articles(){
        $data = DB::select('SELECT * from articles ORDER BY a_id DESC', []);
        return view('Admin.Article.View')->with('data', ['articles' => $data]);
    }

    public function edit_article(Request $request){
        if($request->a_id == ''){
            return back();
        }

        $a_id = $request->a_id;
        $data = (DB::select('SELECT * from articles WHERE a_id = ?', [$a_id]));

        if(count($data) == 0){
            return back();
        }

        $categories_data = DB::select('SELECT * from categories ORDER BY c_id DESC', []);
        return view('Admin.Article.Edit')->with('data', ['article' => $data[0], 'categories_data'=> $categories_data, 'all_states' => TermiiSms::get_all_state()]);
    }

    public function edit_article_now(Request $request){
        if($request->article_title == ''){
            return 'article title is required';
        }
        if($request->category_id == ''){
            return 'category is required';
        }
        if($request->article_desc == ''){
            return 'article desc is required';
        }
        if($request->p_content == ''){
            return 'article content is required';
        }
        if($request->article_location == ''){
            return 'article location is required';
        }
        if($request->bb_text == ''){
            return 'bottom button text is required';
        }
        if($request->bb_link == ''){
            return 'bottom button link is required';
        }
        if($request->a_id == ''){
            return 'wahala....';
        }
        if($request->a_status == ''){
            return 'wahala....';
        }

        $article_title = $request->article_title;
        $category_id = $request->category_id;
        $article_desc = $request->article_desc;
        $p_content = $request->p_content;
        $article_location = strtoupper($request->article_location);
        $bb_text = $request->bb_text;
        $bb_link = $request->bb_link;
        $a_id = $request->a_id;
        $a_status = intval($request->a_status);

        if($request->article_image == ''){
            // without image
            $sql = 'UPDATE articles set c_id = ?, a_title = ?, a_desc = ?, a_content = ?, a_location = ?, a_status = ?, bottom_button_link = ?, bottom_button_text = ? where a_id = ?';
            (DB::update($sql, [$category_id, $article_title, $article_desc, $p_content, $article_location, $a_status, $bb_link, $bb_text, $a_id]));
            return redirect(url('/admin/view-articles'));
        }else{
            $article_image = $request->article_image;

            // update image
            //validate and move image
            $image_validator = Validator::make(['image' => $article_image],['image' => 'mimes:jpeg,jpg,png,gif|required|max:10000']);
            if ($image_validator->fails())
            {
                // Redirect or return json to frontend with a helpful message to inform the user
                //not an image
                return response()->json(['status'=>0, 'message'=>'not an image uploaded'],200);
            }

            $image_fileName = time().".".$article_image->extension();

            if( !($article_image->move(public_path('images/article_image'),$image_fileName)) ){
                //error
                return response()->json(['status'=>0, 'message'=>'error uploading image'],200);
            }

            // update database
            $sql = 'UPDATE articles set c_id = ?, a_title = ?, a_desc = ?, a_content = ?, a_location = ?, a_status = ?, bottom_button_link = ?, bottom_button_text = ?, a_image = ? where a_id = ?';
            (DB::update($sql, [$category_id, $article_title, $article_desc, $p_content, $article_location, $a_status, $bb_link, $bb_text, $image_fileName, $a_id]));
            return redirect(url('/admin/view-articles'));
        }
    }
}
