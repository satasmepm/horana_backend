@extends('Layout.app')
@section('content')

    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-inbox bg-blue"></i>
                    <div class="d-inline">
                        <h5>Customers</h5>
                        <span>view customers</span>
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
                                <th>Name</th>
                                <th>NIC number</th>
                                <th>Mobile number</th>
                                <th class="nosort">Email address</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td>001</td>

                                <td>Erich Heaney</td>
                                <td>erich@example.com</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="#"><i class="ik ik-eye"></i></a>
                                        <a href="#"><i class="ik ik-edit-2"></i></a>
                                        <a href="#"><i class="ik ik-trash-2"></i></a>
                                    </div>
                                </td>
                            </tr> --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">View customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="exampleInputUsername1">Customer name</label>
                                <input type="text" class="form-control" id="cus_name"
                                    placeholder="Enter customer name here" name="cus_name" value="{{ old('cus_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">NIC number</label>
                                <input type="text" class="form-control" id="cus_nic" placeholder="Enter address here"
                                    name="cus_nic" value="{{ old('cus_nic') }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Phone number</label>
                                <input type="number" class="form-control" id="cus_phone"
                                    placeholder="Enter phone number here" name="cus_phone" value="{{ old('cus_phone') }}">
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Email address</label>
                                <input type="email" class="form-control" id="cus_email" placeholder="Enter email here"
                                    name="cus_email" value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <textarea type="text" class="form-control" id="cus_address" placeholder="Enter address here" name="cus_address"
                                    value="{{ old('cus_address') }}" rows="3"></textarea>


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
                ajax: "{{ url('geAllData') }}",
                "columns": [{
                        "data": "id"
                    }, {
                        "data": "cus_name"
                    },
                    {
                        "data": "cus_nic"
                    },
                    {
                        "data": "cus_phone"
                    },
                    {
                        "data": "cus_email"
                    },
                    {
                        "data": "cus_address"
                    }, {
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
                                '<a href="customer/' + row.id + '/edit"><button  data-id=' + row
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
                    url: "{{ url('customer') }}/" + $id,
                    type: "get",
                    dataType: "json",
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {

                        $('input[name="cus_name"]').val(response.data.cus_name);
                        $('input[name="cus_nic"]').val(response.data.cus_name);
                        $('input[name="cus_phone"]').val(response.data.cus_phone);
                        $('input[name="cus_email"]').val(response.data.cus_email);
                        $("textarea#cus_address").val(response.data.cus_address);


                    },
                })
            });
            //data load in to modal selected employee
            $(document).on('click', '#edit', function() {

                $id = $(this).data('id');

                $.ajax({
                    url: "{{ url('customer') }}/" + $id + "/edit",
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
                        url: "{{ url('/customer') }}/" + $id,
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
