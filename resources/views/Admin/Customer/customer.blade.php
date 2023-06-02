@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Customer</h5>
                        <span>add customer detals</span>
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
                    <form class="forms-sample" action="{{ url('/customer') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="exampleInputUsername1">Customer name</label>
                                    <input type="text" class="form-control" id="cus_name"
                                        placeholder="Enter customer name here" name="cus_name"
                                        value="{{ old('cus_name') }}">
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">NIC number</label>
                                    <input type="text" class="form-control" id="cus_nic"
                                        placeholder="Enter address here" name="cus_nic" value="{{ old('cus_nic') }}">
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_nic') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Phone number</label>
                                    <input type="number" class="form-control" id="cus_phone"
                                        placeholder="Enter phone number here" name="cus_phone"
                                        value="{{ old('cus_phone') }}">
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_phone') }}</span>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    <button type="button" id="clearBtn" class="btn btn-light">Cancel</button>
                                </div>


                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Email address</label>
                                    <input type="email" class="form-control" id="cus_email" placeholder="Enter email here"
                                        name="cus_email" value="{{ old('name') }}">

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Address</label>
                                    <textarea type="text" class="form-control" id="cus_address" placeholder="Enter address here" name="cus_address"
                                        value="{{ old('cus_address') }}" rows="4"></textarea>
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_address') }}</span>
                                </div>

                            </div>
                        </div>
                    </form>

                    {{-- <form class="forms-sample" action="{{url('/pdf')}}" method="GET"  >

                        <div class="row">

                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                        </div>
                    </form> --}}
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

            $("#clearBtn").on("click", function() {
                $("#cus_name").val("");
                $("#cus_nic").val("");
                $("#cus_phone").val("");
                $("#cus_email").val("");
                $("#cus_address").val("");
            });
        });
    </script>
@endsection
