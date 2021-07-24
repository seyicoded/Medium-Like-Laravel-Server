<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Articles extends Controller
{
    //

    public function create_article(Request $request){
        $categories_data = DB::select('SELECT * from categories ORDER BY c_id DESC', []);
        return view('Admin.Article.Create')->with('data', ['categories_data'=> $categories_data]);
    }
}
