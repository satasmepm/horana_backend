@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-inbox bg-blue"></i>
                    <div class="d-inline">
                        <h5>Installments</h5>
                        <span>view installments</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Tables</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <form id="frm" class="form-inline" action="{{ url('/installemt_by_home_id') }}" method="POST">
                {{ csrf_field() }}


                <div class="input-group mb-2 mr-sm-2">
                    <select style="width:150px" name="tower_id" id="tower_id" class="form-control">
                        <option value="">Select an Tower </option>
                        @foreach ($towers as $tower)
                            <option value="{{ $tower->id }}">{{ $tower->tower_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                    <select style="width:150px" name="floor_id" id="floor_id" class="form-control">
                        <option value="">Select an Floor </option>
                        @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}">{{ $floor->floor_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                    <select style="width:150px" name="home_id" id="home_id" class="form-control">
                        <option value="">Select an Home </option>
                        @foreach ($homes as $home)
                            <option value="{{ $home->id }}">{{ $home->home_number }}</option>
                        @endforeach
                    </select>
                </div>


                <button id="submit" type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
            <div class="card">




                <table id="cities" class="table data-table dataTables-example">
                    <thead>
                        <tr>
                            <th>#Id</th>
                            <th>Installment number</th>
                            <th>Installment Amount</th>
                            <th>Rmainng</th>
                            <th>Balance</th>
                            <th>Payment date</th>
                            <th>Pay amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        @for ($row = 0; $row < count($myCollection); $row++)
                            @if ($row == 5)
                                <tr>
                                    @for ($col = 0; $col < count($myCollection[$row]); $col++)
                                        <td>{{ $myCollection[$row][$col] }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-center">Monthly installment with 2,60,000</td>
                                </tr>
                            @elseif($row == 11)
                                <tr>
                                    @for ($col = 0; $col < count($myCollection[$row]); $col++)
                                        <td>{{ $myCollection[$row][$col] }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-center">Monthly installment with 1,15,000</td>
                                </tr>
                            @else
                                <tr>
                                    @for ($col = 0; $col < count($myCollection[$row]); $col++)
                                        <td>{{ $myCollection[$row][$col] }}</td>
                                    @endfor
                                </tr>
                            @endif
                        @endfor

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">View tower</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="exampleInputUsername1">Tower name</label>
                                <input type="text" class="form-control" id="tower_name"
                                    placeholder="Enter tower name here" name="tower_name" value="{{ old('tower_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Location</label>
                                <input type="email" class="form-control" id="tower_location"
                                    placeholder="Enter location here" name="tower_location"
                                    value="{{ old('tower_location') }}">
                            </div>

                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tower_id').on('change', function() {
                $id = $(this).val();
                $.ajax({
                    url: "{{ url('get_floor_by_tower_id') }}/" + $id,
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        console.log("lenfth os : " + response.data.length);
                        if (response.data.length > 0) {
                            $('#floor_id option:not(:first)').remove();
                            for (var i = 0; i < response.data.length; i++) {
                                $('#floor_id').append(
                                    '<option value="' + response.data[i].id + '">' +
                                    response
                                    .data[i].floor_number + '</option>'
                                );
                            }
                        } else {
                            $('#floor_id option:not(:first)').remove();
                        }

                    },

                })

            });
            $('#floor_id').on('change', function() {
                $id = $(this).val();
                $.ajax({
                    url: "{{ url('get_home_by_floor_id') }}/" + $id,
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        console.log("lenfth os : " + response.data.length);
                        if (response.data.length > 0) {
                            $('#home_id option:not(:first)').remove();
                            for (var i = 0; i < response.data.length; i++) {
                                $('#home_id').append(
                                    '<option value="' + response.data[i].id + '">' +
                                    response.data[i].home_number + '</option>'
                                );
                            }
                        } else {
                            $('#home_id option:not(:first)').remove();
                        }

                    },

                })

            });
        });
    </script>
@endsection
