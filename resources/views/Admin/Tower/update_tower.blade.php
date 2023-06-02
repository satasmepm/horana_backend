@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Tower</h5>
                        <span>add tower detals</span>
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
                    <form class="forms-sample" action="{{ route('tower.update', $tower->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Tower name</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1"
                                        placeholder="Enter tower name here" name="tower_name"
                                        value="{{ $tower->tower_name }}">
                                    <span
                                        class="text-danger error-text tower_name_error">{{ $errors->first('tower_name') }}</span>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-warning mr-2">Update</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Tower location</label>
                                    <input type="text" class="form-control" id="exampleInputConfirmPassword1"
                                        placeholder="Enter tower location here" name="tower_location"
                                        value="{{ $tower->tower_location }}">
                                    <span
                                        class="text-danger error-text tower_location_error">{{ $errors->first('tower_location') }}</span>
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


        });
    </script>
@endsection
