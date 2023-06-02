@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Progress</h5>
                        <span>update progress</span>
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
                    <form class="forms-sample" action="{{ route('progress.update', $progress->id) }}" method="POST"
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
                                            <option @if ($tower->id == $progress->tower->id) selected @endif
                                                value="{{ $tower->id }}">{{ $tower->tower_name }}</option>
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
                                            <option @if ($floor->id == $progress->floor->id) selected @endif
                                                value="{{ $floor->id }}">{{ $floor->floor_number }}</option>
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
                                            <option @if ($home->id == $progress->home->id) selected @endif
                                                value="{{ $home->id }}">{{ $home->home_number }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="text-danger error-text home_id_error">{{ $errors->first('home_id') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Date</label>
                                    <input type="date" style="font-weight:bold" class="form-control"
                                        id="pr_date" name="pr_date" placeholder="Enter date Here"
                                        value="{{$progress->pr_date }}">
                                    <span class="text-danger error-text pr_date_error"></span>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-warning mr-2">Update</button>
                                    <button class="btn btn-light">Cancel</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <img id="image" src="{{ asset('/uploads/progress') }}/{{ $progress->pr_image }}"
                                width="150px" style="margin-top:-10px" />
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Images</label>
                                    <input type="file" class="form-control" id="pr_image"
                                        placeholder="Enter image here" name="pr_image"
                                        value="{{ old('pr_image') }}">
                                    <span
                                        class="text-danger error-text pr_image_error">{{ $errors->first('pr_image') }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Remark</label>
                                    <textarea type="text" class="form-control" id="pr_remark" placeholder="Enter remark here" name="pr_remark"
                                    rows="3">@if($errors->any()){{old('pr_remark')}}@elseif(!empty($progress->pr_remark)){{$progress->pr_remark}}@endif </textarea>
                                    <span
                                        class="text-danger error-text pr_remark_error">{{ $errors->first('pr_remark') }}</span>
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
