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

            <table id="liveChat_list" style="width: 94%; margin: 3%" class="w3-table w3-bordered w3-striped w3-border w3-hoverable" width="94%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>NAME</th>
                        <th>IMAGE</th>
                        <th>ACTION</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['categories'] as $dt)
                        <tr>
                            <td>{{$dt->c_id}}</td>
                            <td>{{$dt->category_name}}</td>
                            <td><img class="w3-circle" style="width: 60px; height: 60px" src="{{url('images/category_image/'.$dt->categories_image)}}"></td>
                            <td><button onclick="window.location.href = '{{url('/admin/edit-category?c_id='.$dt->c_id)}}'" class="w3-btn w3-round w3-btn-block w3-green">Edit</button></td>
                            <td><button onclick="window.location.href = '{{url('/admin/delete-category?c_id='.$dt->c_id)}}'" class="w3-btn w3-round w3-btn-block w3-red">Delete</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
