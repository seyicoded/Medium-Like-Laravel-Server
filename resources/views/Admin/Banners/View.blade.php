@extends('Admin.Layout.app')
@section('content')
    <div>
        <h1>All Banners</h1>

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

            {{-- modal start --}}
            <div id="id01" class="w3-modal">
                <div class="w3-modal-content">
                <div class="w3-container">
                    <div style="flex-direction: row; justify-content: flex-end; display: flex;">
                        <button onclick="document.getElementById('id01').style.display='none'" class="w3-btn w3-white w3-text-black w3-card-4 w3-round">x</button>
                    </div>

                    <br>
                        <h1>Create new Banner</h1>
                        <br>
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <input class="w3-input" name="company_name" placeholder="company name" required/>
                                <label class="w3-label w3-validate">NAME</label>
                            </div>
                            <br>

                            <div>
                                <input class="w3-input" name="company_link" placeholder="company http-link" required/>
                                <label class="w3-label w3-validate">LINK</label>
                            </div>
                            <br>

                            <div>
                                <input type="file" class="w3-input" name="company_image" placeholder="company image" required/>
                                <label class="w3-label w3-validate">IMAGE</label>
                            </div>
                            <br>

                            <div>
                                <input type="submit" class="w3-btn w3-btn-block" name="submit" value="submit" value="CREATE"/>
                            </div>
                            <br>
                        </form>
                    <br>
                </div>
                </div>
            </div>
            {{-- modal end --}}

            <div style="flex-direction: row; justify-content: flex-end; display: flex;">
                <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn w3-blue w3-text-white w3-card-4 w3-round">+</button>
            </div>

            <table id="liveChat_list" style="width: 94%; margin: 3%" class="w3-table w3-small w3-bordered w3-striped w3-border w3-hoverable" width="94%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>NAME</th>
                        <th>IMAGE</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['banners'] as $dt)
                        <tr>
                            <td>{{$dt->b_id}}</td>
                            <td>{{$dt->b_name}}</td>
                            <td><img class="w3-circle" style="width: 60px; height: 60px" src="{{url('images/banners_image/'.$dt->b_image)}}"></td>
                            <td>{{($dt->b_status == 1) ? "ACTIVE":"DISABLED" }}</td>
                            <td><button onclick="window.location.href = '{{url('/admin/toggle-banners?b_id='.$dt->b_id)}}'" class="w3-btn w3-round w3-btn-block w3-green">TOGGLE</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
