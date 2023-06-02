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
                    <form class="forms-sample" action="{{ route('asign_home.update', $asign_homes->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Tower name</label>
                                    <select name="tower_id" id="tower_id" class="form-control">
                                        <option value="">Select an option</option>
                                        @foreach ($towers as $tower)
                                            <option @if($tower->id==$asign_homes->tower->id) selected @endif  value="{{ $tower->id }}">{{ $tower->tower_name }}</option>
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
                                            <option  @if($floor->id==$asign_homes->floor->id) selected @endif value="{{ $floor->id }}">{{ $floor->floor_number }}</option>
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
                                            <option @if($home->id==$asign_homes->home->id) selected @endif value="{{ $home->id }}">{{ $home->home_number }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="text-danger error-text floor_id_error">{{ $errors->first('floor_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Customer NIC Number</label>
                                    <input type="text" style="font-weight:bold" class="form-control" id="cus_nic"
                                        name="cus_nic" placeholder="Enter customer NIC Here" value="{{ $asign_homes->customer->cus_nic}}">
                                    <span class="text-danger error-text cus_nic_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Customer Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Customer name here"
                                        readonly name="cus_name" id="cus_name" value="{{ $asign_homes->customer->cus_name }}">
                                    <span
                                        class="text-danger error-text cus_name_error">{{ $errors->first('cus_name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Email address</label>
                                    <input type="text" class="form-control" placeholder="Enter email address here"
                                        readonly name="cus_email" id="cus_email" value="{{ $asign_homes->customer->cus_email}}">
                                    <span
                                        class="text-danger error-text cus_email_error">{{ $errors->first('cus_email') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Down payment</label>
                                    <input type="number" style="font-weight:bold" class="form-control" id="ah_down_payment"
                                        name="ah_down_payment" placeholder="Enter down payment Here"
                                        value="{{ $asign_homes->ah_down_payment}}">
                                    <span class="text-danger error-text ah_down_payment_error"></span>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-warning mr-2">Update</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" style="font-weight:bold" class="form-control" id="cus_id"  value="{{ $asign_homes->cus_id}}"
                                    name="cus_id" placeholder="Enter down payment Here">

                                <div class="form-group">
                                    <label for="exampleInputUsername1">Reserve date</label>
                                    <input type="date" style="font-weight:bold" class="form-control"
                                        id="ah_reserve_date" name="ah_reserve_date" placeholder="Enter down payment Here"
                                        value="{{ $asign_homes->ah_reserve_date}}">
                                    <span class="text-danger error-text ah_reserve_date_error"></span>
                                </div>
                                <img id="image" src="{{asset('/uploads/asign_homes')}}/{{$asign_homes->ah_reserve_recipt}}" width="110px" style="margin-top:-10px" />
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Asign recipt</label>
                                    <input type="file" class="form-control" id="ah_reserve_recipt"
                                        placeholder="Enter customer name here" name="ah_reserve_recipt"
                                        @if($errors->any())
                                        value="{{old('ah_reserve_recipt')}}"
                                        @elseif(!empty($asign_homes->ah_reserve_recipt))
                                        value="{{$asign_homes->ah_reserve_recipt}}"
                                                             @endif>
                                    <span
                                        class="text-danger error-text ah_reserve_recipt_error">{{ $errors->first('ah_reserve_recipt') }}</span>
                                </div>
                                @if ($asign_homes->ah_agreement!='')
                                    <img id="image" src="/images/res_img/pdf.png" width="40px" style="margin-top:-10px" />


                                @endif

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
                                        rows="3">@if($errors->any()){{old('ah_remark')}}@elseif(!empty($asign_homes->ah_remark)){{$asign_homes->ah_remark}}@endif </textarea>
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('ah_remark') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="">Payment Type</label>
                                    <select name="ah_type" id="ah_type" class="form-control">
                                        <option value="">Select an option</option>
                                        <option value="1" @if($asign_homes->ah_type==1) selected @endif>Open</option>
                                        <option value="2" @if($asign_homes->ah_type==2) selected @endif>Defaulted</option>
                                        <option value="3" @if($asign_homes->ah_type==3) selected @endif>----Fraud</option>
                                        <option value="4" @if($asign_homes->ah_type==4) selected @endif>----Investigation</option>
                                        <option value="5" @if($asign_homes->ah_type==5) selected @endif>----Legal</option>
                                        <option value="6" @if($asign_homes->ah_type==6) selected @endif>Denied</option>
                                        <option value="7" @if($asign_homes->ah_type==6) selected @endif>Closed</option>
                                    </select>
                                    <span class="text-danger error-text ah_type_error"></span>
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
