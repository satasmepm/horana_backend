@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-inbox bg-blue"></i>
                    <div class="d-inline">
                        <h5>Tower</h5>
                        <span>view towers</span>
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
            <div class="card">

                <div class="card-body">
                    <table id="cities" class="table data-table dataTables-example">
                        <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Tower name</th>
                                <th>Location</th>

                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
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

            //datatable columns
            var table = $('#cities').DataTable({
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ url('geAllTowerData') }}",
                "columns": [{
                        "data": "id"
                    }, {
                        "data": "tower_name"
                    },
                    {
                        "data": "tower_location"
                    },
                    {
                        "data": null,
                        render: function(data, type, row) {
                            if (row.status == 0) {
                                return '<span class="badge badge-pill badge-success mb-1">Active</span>';
                            } else {
                                return '<span class="badge badge-pill badge-danger mb-1">Inactive</span>';
                            }
                        }
                    }, {
                        "data": null,
                        render: function(data, type, row) {
                            return '<button style="margin-right:5px" data-id=' + row.id +
                                ' class="btn btn-sm   btn-light" data-toggle="modal" data-target="#exampleModalLong" id="view"><i class="ik ik-eye"></i></button>' +
                                '<a href="tower/' + row.id + '/edit"><button  data-id=' + row
                                .id +
                                ' class="btn btn-sm  btn-warning"  ><i class="ik ik-edit-2"></i></button></a>' +
                                '<button style="margin-left:5px" data-id=' + row.id +
                                ' class="btn btn-sm  btn-danger" id="delete"><i class="ik ik-trash-2"></i></button>';
                        }
                    },


                ]
            });
            //data load in to modal selected employee
            $(document).on('click', '#view', function() {

                $id = $(this).data('id');

                $.ajax({
                    url: "{{ url('tower') }}/" + $id,
                    type: "get",
                    dataType: "json",
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {


                        $('input[name="tower_name"]').val(response.data.tower_name);
                        $('input[name="tower_location"]').val(response.data.tower_location);


                    },
                })
            });
            //data load in to modal selected employee
            $(document).on('click', '#edit', function() {

                $id = $(this).data('id');

                $.ajax({
                    url: "{{ url('tower') }}/" + $id + "/edit",
                    type: "get",
                    dataType: "json",
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {


                    },
                })
            });
            $(document).on('click', '#delete', function() {
                $id = $(this).data('id');

                console.log($id);
                if (confirm('Are you sure you want to delete')) {
                    $.ajax({
                        url: "{{ url('/tower') }}/" + $id,
                        type: "DELETE",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            table.ajax.reload();

                            console.log(response);
                            if (response.status == "success") {
                                swal({
                                    title: "Good job!",
                                    text: "Successfuly delete record!",
                                    icon: "success",
                                    button: "Ok!",
                                });
                            }
                        },
                    })
                }
            });
            var response = '{{ Session::get('msg') }}';
            if (response == "update") {
                swal({
                    title: "Good job!",
                    text: "Successfuly updated record!",
                    icon: "success",
                    button: "Ok!",
                });
            }else if(response == "insert"){
                swal({
                    title: "Good job!",
                    text: "Successfuly inserted record!",
                    icon: "success",
                    button: "Ok!",
                });
            }
            var remove = '{{ Session::forget('msg') }}';

        });
    </script>
@endsection
