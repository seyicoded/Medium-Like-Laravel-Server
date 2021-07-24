<?php
    $categories = $data['categories_data'];
?>
@extends('Admin.Layout.app')
@section('content')
    <div>
        <h1>Create a Blesify Article</h1>

        <form method="POST" enctype="multipart/form-data" class="w3-card-8 w3-container w3-white w3-padding-16 w3-round" style="margin-left: 20%; width: 80%; margin: 4% 10%">
            <h5 class="w3-text-grey w3-center w3-small">fill information below to create</h5>
            @csrf
            <br>

            <div class="w3-container">
                <input class="w3-input" type="text" name="article_title" placeholder="Enter Category Title" required/>
                <label class="w3-label w3-validate">Article Title</label>
            </div>
            <br>

            <div class="w3-container">
                <select class="w3-select" name="category_id">
                    
                </select>
                <label class="w3-label w3-validate">Article Category</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="file" name="article_image" required/>
                <label class="w3-label w3-validate">Article Image</label>
            </div>
            <br>


        </form>
    </div>
@endsection
