@extends('Admin.Layout.app')
@section('content')
    <div>
        <h1>All Categories</h1>

        <div class="w3-container w3-card-4 w3-round w3-white w3-padding-8" style="margin-top: 4%">
            <br>
            <script>
                $(document).ready(function () {
                    $('#liveChat_list').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                    });
                });
            </script>

            <table id="liveChat_list" style="width: 94%; margin: 3%" class="w3-table w3-small w3-bordered w3-striped w3-border w3-hoverable" width="94%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>CATEGORY</th>
                        <th>TITILE</th>
                        <th>DESC</th>
                        <th>IMAGE</th>
                        <th>LOC</th>
                        <th>BB-Text</th>
                        <th>BY</th>
                        <th>STATUS</th>
                        <th>DATE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['articles'] as $dt)
                        <tr>
                            <td>{{$dt->a_id}}</td>
                            <td>{{ (DB::select("SELECT * FROM categories WHERE c_id = ?", [$dt->c_id])[0])->category_name}}</td>
                            <td>{{$dt->a_title}}</td>
                            <td>{{$dt->a_desc}}</td>
                            <td><img class="w3-circle" style="width: 60px; height: 60px" src="{{url('images/article_image/'.$dt->a_image)}}"></td>
                            <td>{{$dt->a_location}}</td>
                            <td><a href="{{$dt->bottom_button_link}}">{{$dt->bottom_button_text}}</a></td>
                            <td>{{(intval($dt->by_id) == 0) ? 'ADMIN' : 'USER'}}</td>
                            <td>{{(intval($dt->a_status) == 0) ? 'DISABLED' : 'ACTIVE'}}</td>
                            <td>{{date("Y-m-d",strtotime($dt->a_date))}}</td>
                            <td><button onclick="window.location.href = '{{url('/admin/edit-article?a_id='.$dt->a_id)}}'" class="w3-btn w3-round w3-btn-block w3-green">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
