<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Category extends Controller
{
    //

    public function create_category(){
        return view('Admin.Category.Create');
    }

    public function create_category_now(Request $request){
        if($request->category_name == ''){
            return 'category name is required';
        }

        if($request->category_image == ''){
            return 'category image is required';
        }

        $category_name = $request->category_name;
        $category_image = $request->category_image;

        //validate and move image
        $image_validator = Validator::make(['image' => $category_image],['image' => 'mimes:jpeg,jpg,png,gif|required|max:10000']);
        if ($image_validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            //not an image
            return response()->json(['status'=>0, 'message'=>'not an image uploaded'],200);
        }

        $image_fileName = time().".".$category_image->extension();

        if( !($category_image->move(public_path('images/category_image'),$image_fileName)) ){
            //error
            return response()->json(['status'=>0, 'message'=>'error uploading image'],200);
        }

        // update database

        if( (DB::insert('INSERT into categories (category_name, categories_image, c_status) values (?, ?, ?)', [$category_name, $image_fileName, 1])) ){
            return redirect(url('/admin/view-categories'));
        }else{
            return "an error occurred";
        }

    }

    public function view_categories(){
        $data = DB::select('SELECT * from categories ORDER BY c_id DESC', []);
        return view('Admin.Category.View')->with('data', ['categories' => $data]);
    }

    public function delete_category(Request $request){
        if($request->c_id == ''){
            return back();
        }

        $c_id = $request->c_id;
        try{
            $image = (DB::select('SELECT * from categories WHERE c_id = ?', [$c_id]))[0]->categories_image;
            unlink(public_path('images/category_image').$image);
            unlink(public_path('images/category_image').$image);
        }catch(\Exception $e){

        }

        DB::delete('DELETE FROM categories where c_id = ?', [$c_id]);
        return back();
    }

    public function edit_category(Request $request){
        if($request->c_id == ''){
            return back();
        }

        $c_id = $request->c_id;
        $data = (DB::select('SELECT * from categories WHERE c_id = ?', [$c_id]));

        if(count($data) == 0){
            return back();
        }

        return view('Admin.Category.Edit')->with('data', ['category' => $data[0]]);
    }

    public function edit_category_now(Request $request){
        if($request->c_id == ''){
            return back();
        }
        $c_id = $request->c_id;

        if($request->category_name == ''){
            return 'category name is required';
        }

        $category_name = $request->category_name;

        if($request->category_image == ''){
            // code to run if image isn't been changed
            (DB::update('UPDATE categories set category_name = ? where c_id = ?', [$category_name, $c_id]));
            return redirect(url('/admin/view-categories'));
        }

        $category_image = $request->category_image;

        //validate and move image
        $image_validator = Validator::make(['image' => $category_image],['image' => 'mimes:jpeg,jpg,png,gif|required|max:10000']);
        if ($image_validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            //not an image
            return response()->json(['status'=>0, 'message'=>'not an image uploaded'],200);
        }

        $image_fileName = time().".".$category_image->extension();

        if( !($category_image->move(public_path('images/category_image'),$image_fileName)) ){
            //error
            return response()->json(['status'=>0, 'message'=>'error uploading image'],200);
        }

        // update database

        // (DB::insert('INSERT into categories (category_name, categories_image, c_status) values (?, ?, ?)', [$category_name, $image_fileName, 1]));
        (DB::update('UPDATE categories set category_name = ?, categories_image = ? where c_id = ?', [$category_name, $image_fileName, $c_id]));
        return redirect(url('/admin/view-categories'));
    }
}
