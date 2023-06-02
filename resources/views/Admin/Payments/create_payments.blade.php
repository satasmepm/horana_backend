@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Payments</h5>
                        <span>add payment</span>
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
                    <form class="forms-sample" action="{{ url('/payments') }}" method="POST" enctype="multipart/form-data">
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
                                        class="text-danger error-text home_id_error">{{ $errors->first('home_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Customer NIC Number</label>
                                    <input type="text" style="font-weight:bold" readonly class="form-control" id="cus_nic"
                                        name="cus_nic" placeholder="Enter customer NIC Here" value="{{ old('cus_nic') }}">
                                    <span class="text-danger error-text cus_nic_error">{{ $errors->first('cus_nic') }}</span>
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


                            </div>
                            <div class="col-md-6">
                                <input type="hidden" class="form-control" id="cus_id" name="cus_id" >
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Payment Date</label>
                                    <input type="date" class="form-control" id="exampleInputUsername1"
                                        placeholder="Enter customer name here" name="pay_date"
                                        value="{{ old('pay_date') }}">
                                    <span
                                        class="text-danger error-text pay_date_error">{{ $errors->first('pay_date') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Payment Slip</label>
                                    <input type="file" class="form-control" id="exampleInputUsername1"
                                        placeholder="Enter customer name here" name="pay_slip"
                                        value="{{ old('pay_slip') }}">
                                    <span
                                        class="text-danger error-text pay_slip_error">{{ $errors->first('pay_slip') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Payment Amount</label>
                                    <input type="number" class="form-control" id="exampleInputConfirmPassword1"
                                        placeholder="Enter tower location here" name="pay_amount"
                                        value="{{ old('pay_amount') }}">
                                    <span
                                        class="text-danger error-text pay_amount_error">{{ $errors->first('pay_amount') }}</span>
                                </div>
                            </div>

                        </div>
                        <div>
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            {{-- <button class="btn btn-light">Cancel</button> --}}
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
                    url: "{{ url('get_home_by_floorid') }}/" + $id,
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
            $('#home_id').on('change', function() {
                $id = $(this).val();
                $.ajax({
                    url: "{{ url('get_customer_by_home_id') }}/" + $id,
                    type: "get",
                    dataType: "json",
                    success: function(response) {
                        if (response.data.length > 0) {
                            for (var i = 0; i < response.data.length; i++) {

                                $('#cus_id').val(response.data[i].cus_id);
                                $('#cus_name').val(response.data[i].cus_name);
                                $('#cus_nic').val(response.data[i].cus_nic);
                                $('#cus_email').val(response.data[i].cus_email);

                            }
                        } else {
                            $('#cus_id').val("");
                            $('#cus_name').val("");
                            $('#cus_nic').val("");
                            $('#cus_email').val("");
                        }

                    },

                })

            });

        });
    </script>
@endsection
