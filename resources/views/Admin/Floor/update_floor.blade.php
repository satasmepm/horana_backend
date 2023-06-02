@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Floor</h5>
                        <span>update floor</span>
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
                    <form class="forms-sample" action="{{ url('/floor') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Tower name</label>
                                    <select name="tower_id" id="tower_id" class="form-control">
                                        <option value="">Select an option</option>
                                        @foreach ($towers as $tower)
                                            <option @if ($tower->id == $floor->tower->id) selected @endif value="{{ $tower->id }}">{{ $tower->tower_name }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="text-danger error-text tower_id_error">{{ $errors->first('tower_id') }}</span>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-warning mr-2">Update</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Floor Number</label>
                                    <input type="text" class="form-control" id="exampleInputConfirmPassword1"
                                        placeholder="Enter tower location here" name="floor_number"
                                        value="{{ $floor->floor_number }}">
                                    <span
                                        class="text-danger error-text floor_number_error">{{ $errors->first('floor_number') }}</span>
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


        });
    </script>
@endsection
