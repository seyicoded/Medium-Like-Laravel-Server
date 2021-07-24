<?php
    $categories = $data['categories_data'];
    $all_states = $data['all_states'];
?>
@extends('Admin.Layout.app')
@section('content')
    <div>
        <h1>Create a Blesify Article</h1>

        <form method="POST" onsubmit="reprocess()" enctype="multipart/form-data" class="w3-card-8 w3-container w3-white w3-padding-16 w3-round" style="margin-left: 20%; width: 80%; margin: 4% 10%">
            <h5 class="w3-text-grey w3-center w3-small">fill information below to create</h5>
            @csrf
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="article_title" placeholder="Enter Article Title" required/>
                <label class="w3-label w3-validate">Article Title</label>
            </div>
            <br>

            <div class="w3-container">
                <select class="w3-select w3-round" name="category_id">
                    @foreach ($categories as $dt)
                        <option value="{{$dt->c_id}}">{{$dt->category_name}}</option>
                    @endforeach
                </select>
                <label class="w3-label w3-validate">Article Category</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="article_desc" placeholder="Enter Article Description" maxlength="760" required/>
                <label class="w3-label w3-validate">Article Description <span class="w3-small w3-text-gray">760 max characters</span></label>
            </div>
            <br>

            <div class="w3-container">
                <textarea class="w3-input w3-round" style="height:400px; display: none;" name="p_content" placeholder="Enter Product Explanation"></textarea>

                <div id="editor">
                    <h1>Post Content Goes Here</h1>
                </div>
                <label class="w3-label w3-validate">Post Content</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="file" name="article_image" required/>
                <label class="w3-label w3-validate">Article Image</label>
            </div>
            <br>

            <div class="w3-container">
                <select class="w3-select w3-round" name="article_location">
                    @foreach ($all_states as $dt)
                        <option value="{{$dt}}">{{$dt}}</option>
                    @endforeach
                </select>
                <label class="w3-label w3-validate">Article Location</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="bb_text" placeholder="Enter Bottom Button Text" maxlength="70" required/>
                <label class="w3-label w3-validate">Bottom Button Text</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="bb_link" placeholder="Enter Bottom Button ACTION" maxlength="760" required/>
                <label class="w3-label w3-validate">Bottom Button ACTION</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-btn w3-light-blue" style="width: 100%; font-weight: bolder" type="submit" name="submit" value="CREATE"/>
            </div>
            <br>

        </form>
    </div>
@endsection
