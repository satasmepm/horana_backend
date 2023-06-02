@extends('Layout.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('theme/dist/css/toggle-switch.css') }}">
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Customer</h5>
                        <span>update customer detals</span>
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
                    <form action="{{ route('customer.update', $customer->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="exampleInputUsername1">Customer name</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1"
                                        placeholder="Enter customer name here" name="cus_name"
                                        value="{{ $customer->cus_name }}">
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_name') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">NIC number</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        placeholder="Enter address here" name="cus_nic" value="{{ $customer->cus_nic }}">
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_nic') }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Phone number</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1"
                                        placeholder="Enter phone number here" name="cus_phone"
                                        value="{{ $customer->cus_phone }}">
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_phone') }}</span>
                                </div>


                                <div>
                                    <button type="submit" class="btn btn-warning mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>


                            </div>
                            <div class="col-md-6">


                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputConfirmPassword1"
                                        placeholder="Enter email here" name="cus_email" value="{{ $customer->cus_email }}">

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Address</label>
                                    <textarea type="text" class="form-control" id="exampleInputConfirmPassword1" placeholder="Enter address here"
                                        name="cus_address" value="{{ $customer->cus_address }}" rows="4">{{ $customer->cus_address }}</textarea>
                                    <span
                                        class="text-danger error-text emp_mobile_error">{{ $errors->first('cus_address') }}</span>
                                </div>

                                <label class="toggle-switch my-toggle-switch" style="float: left;">
                                    <input type="checkbox" id="my-toggle-switch-input" name="checkbox-data" @if ($customer->status==0) checked @endif/>
                                    <label for="my-toggle-switch-input"></label>

                                </label>
                                <label for="input-field" style="margin-top:15px">Active</label>

                                <pre>
                    <style contenteditable="true">
                    .my-toggle-switch {
                        --bar-height: 15px;
                        --bar-width: 36px;
                        --knob-size: 18px;
                        --switch-theme-rgb: 232, 26, 170;
                    }
                    </style>
                                    </pre>

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
            if (response == "update") {
                swal({
                    title: "Good job!",
                    text: "Successfuly updated record!",
                    icon: "success",
                    button: "Ok!",
                });
            }
            $('#my-toggle-switch-input').click(function() {
                if ($(this).prop('checked')) {
                    $('label[for="input-field"]').text('Active');
                } else {
                    $('label[for="input-field"]').text('Inactive');
                }
            });

        });
    </script>
@endsection
