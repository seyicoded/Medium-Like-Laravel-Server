@extends('Admin.Layout.app')
@section('content')
    <div>
        <h1>Edit a Blesify Category</h1>

        <form method="POST" enctype="multipart/form-data" class="w3-card-8 w3-container w3-white w3-padding-16 w3-round" style="margin-left: 20%; width: 60%; margin: 4% 20%">
            <h5 class="w3-text-grey w3-center w3-small">fill information below to edit</h5>
            @csrf
            <input type="hidden" name="c_id" value="{{$data['category']->c_id}}"/>
            <br>
            <div class="w3-container">
                <input class="w3-input" type="text" name="category_name" value="{{$data['category']->category_name}}" placeholder="Enter Category Name" required/>
                <label class="w3-label w3-validate">Category Name</label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-input" type="file" name="category_image"/>
                <img class="w3-round w3-center" style="width: 100%; height: 160px" src="{{url('images/category_image/'.$data['category']->categories_image)}}">
                <br>
                <label class="w3-label w3-validate">Changing Category Image is <span style="color: gray">(optional)</span></label>
            </div>
            <br>

            <div class="w3-container">
                <input class="w3-btn w3-light-blue" style="width: 100%; font-weight: bolder" type="submit" name="submit" value="EDIT"/>
            </div>
            <br>

            <br>
        </form>
    </div>
@endsection
