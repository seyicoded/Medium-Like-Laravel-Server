<?php
    $categories = $data['categories_data'];
    $all_states = $data['all_states'];
?>
@extends('Admin.Layout.app')
@section('content')
    <div>
        <h1>EDIT a Blesify Article</h1>

        <form method="POST" onsubmit="reprocess()" enctype="multipart/form-data" class="w3-card-8 w3-container w3-white w3-padding-16 w3-round" style="margin-left: 20%; width: 80%; margin: 4% 10%">
            <h5 class="w3-text-grey w3-center w3-small">fill information below to EDIT</h5>
            @csrf
            <input type="hidden" name="a_id" value="{{$data['article']->a_id}}"/>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="article_title" value="{{$data['article']->a_title}}" placeholder="Enter Article Title" required/>
                <label class="w3-label w3-validate">Article Title</label>
            </div>
            <br>

            <div class="w3-container">
                <select class="w3-select w3-round" name="category_id">
                    @foreach ($categories as $dt)
                        <option value="{{$dt->c_id}}" {{(($data['article']->c_id) == $dt->c_id) ? 'selected' : ''}}>{{$dt->category_name}}</option>
                    @endforeach
                </select>
                <label class="w3-label w3-validate">Article Category</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="article_desc" value="{{$data['article']->a_desc}}" placeholder="Enter Article Description" maxlength="760" required/>
                <label class="w3-label w3-validate">Article Description <span class="w3-small w3-text-gray">760 max characters</span></label>
            </div>
            <br>

            <div class="w3-container">
                <textarea class="w3-input w3-round" style="height:400px; display: none;" name="p_content" placeholder="Enter Product Explanation"></textarea>

                <div id="editor">
                    {{$data['article']->a_content}}
                </div>
                <label class="w3-label w3-validate">Post Content</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="file" name="article_image"/>
                <img class="w3-round w3-center" style="width: 100%; height: 160px" src="{{url('images/article_image/'.$data['article']->a_image)}}">
                <label class="w3-label w3-validate">Article Image</label>
            </div>
            <br>

            <div class="w3-container">
                <select class="w3-select w3-round" name="article_location">
                    @foreach ($all_states as $dt)
                        <option value="{{$dt}}" {{(($data['article']->a_location) == $dt) ? 'selected' : ''}}>{{$dt}}</option>
                    @endforeach
                </select>
                <label class="w3-label w3-validate">Article Location</label>
            </div>
            <br>

            <div class="w3-container">
                <select class="w3-select w3-round" name="a_status">
                    <option value="1" {{(intval($data['article']->a_status) == '1') ? 'selected' : ''}}>ACTIVE</option>
                    <option value="0" {{(intval($data['article']->a_status) == '0') ? 'selected' : ''}}>DISABLED</option>
                </select>
                <label class="w3-label w3-validate">Article Status</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="bb_text" value="{{$data['article']->bottom_button_link}}" placeholder="Enter Bottom Button Text" maxlength="70" required/>
                <label class="w3-label w3-validate">Bottom Button Text</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="bb_link" value="{{$data['article']->bottom_button_text}}" placeholder="Enter Bottom Button ACTION" maxlength="760" required/>
                <label class="w3-label w3-validate">Bottom Button ACTION</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-btn w3-light-blue" style="width: 100%; font-weight: bolder" type="submit" name="submit" value="EDIT"/>
            </div>
            <br>

        </form>
    </div>
@endsection
