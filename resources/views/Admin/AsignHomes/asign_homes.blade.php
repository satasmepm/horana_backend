@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Asign Home</h5>
                        <span>asign home to customer</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Components</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h3>Basic information</h3>
                </div> --}}
                <div class="card-body">
                    <form class="forms-sample" action="{{ url('/asign_home') }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Tower name</label>
                                    <select name="tower_id" id="tower_id" class="form-control">
                                        <option value="">Select an option</option>
                                        @foreach ($towers as $tower)
                                            <option value="{{ $tower->id }}">{{ $tower->tower_name }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="text-danger error-text tower_id_error">{{ $errors->first('tower_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Floor name</label>
                                    <select name="floor_id" id="floor_id" class="form-control">
                                        <option value="">Select an option</option>
                                        @foreach ($floors as $floor)
                                            <option value="{{ $floor->id }}">{{ $floor->floor_number }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="text-danger error-text floor_id_error">{{ $errors->first('floor_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Home name</label>
                                    <select name="home_id" id="home_id" class="form-control">
                                        <option value="">Select an option</option>
                                        @foreach ($homes as $home)
                                            <option value="{{ $home->id }}">{{ $home->home_number }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="text-danger error-text floor_id_error">{{ $errors->first('floor_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Customer NIC Number</label>
                                    <input type="text" style="font-weight:bold" class="form-control" id="cus_nic"
                                        name="cus_nic" placeholder="Enter customer NIC Here" value="{{ old('cus_nic') }}">
                                    <span class="text-danger error-text cus_nic_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Customer Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Customer name here"
                                        readonly name="cus_name" id="cus_name" value="{{ old('cus_name') }}">
                                    <span
                                        class="text-danger error-text cus_name_error">{{ $errors->first('cus_name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Email address</label>
                                    <input type="text" class="form-control" placeholder="Enter email address here"
                                        readonly name="cus_email" id="cus_email" value="{{ old('cus_email') }}">
                                    <span
                                        class="text-danger error-text cus_email_error">{{ $errors->first('cus_email') }}</span>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    {{-- <button id="clearBtn" class="btn btn-light">Cancel</button> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" style="font-weight:bold" class="form-control" id="cus_id"
                                    name="cus_id" placeholder="Enter down payment Here">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Down payment</label>
                                    <input type="number" style="font-weight:bold" class="form-control" id="ah_down_payment"
                                        name="ah_down_payment" placeholder="Enter down payment Here"
                                        value="{{ old('ah_down_payment') }}">
                                    <span class="text-danger error-text ah_down_payment_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Reserve date</label>
                                    <input type="date" style="font-weight:bold" class="form-control"
                                        id="ah_reserve_date" name="ah_reserve_date" placeholder="Enter down payment Here"
                                        value="{{ old('ah_reserve_date') }}">
                                    <span class="text-danger error-text ah_reserve_date_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Reserve recipt</label>
                                    <input type="file" class="form-control" id="ah_reserve_recipt"
                                        placeholder="Enter customer name here" name="ah_reserve_recipt"
                                        value="{{ old('ah_reserve_recipt') }}">
                                    <span
                                        class="text-danger error-text ah_reserve_recipt_error">{{ $errors->first('ah_reserve_recipt') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Agreement</label>
                                    <input type="file" class="form-control" id="ah_agreement"
                                        placeholder="Enter customer name here" name="ah_agreement"
                                        value="{{ old('ah_agreement') }}">
                                    <span
                                        class="text-danger error-text ah_agreement_error">{{ $errors->first('ah_agreement') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Remark</label>
                                    <textarea type="text" class="form-control" id="ah_remark" placeholder="Enter remark here" name="ah_remark"
                                        value="{{ old('ah_remark') }}" rows="4"></textarea>
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('ah_remark') }}</span>
                                </div>
                            </div>

                        </div>
                    </form>


                </div>
            </div>
        </div>


    </div>
    <script>
        $(document).ready(function() {
            var response = '{{ Session::get('msg') }}';
            if (response == "insert") {
                swal({
                    title: "Good job!",
                    text: "Successfuly inserted record!",
                    icon: "success",
                    button: "Ok!",
                });
            }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $("#cus_nic").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "/autocomplete2-searchCustomer",
                    data: {
                        term: $("#cus_nic").val(),
                        // search: $('#role_id').val(),

                    },
                    dataType: "json",
                    type: "GET",
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                console.log(ui);
                $('#cus_name').val(ui.item.cus_name);
                $('#cus_email').val(ui.item.cus_email);
                $('#cus_id').val(ui.item.id);
                // alert(ui.item.cus_name);
                // $('#firstname').val(ui.item.value);
            }



        });
    </script>
@endsection
