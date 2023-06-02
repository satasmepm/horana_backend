@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-inbox bg-blue"></i>
                    <div class="d-inline">
                        <h5>Payments</h5>
                        <span>view payments</span>
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
                                <th>Floor number</th>
                                <th>Home number</th>
                                <th>Customer name</th>
                                <th>Payment date</th>
                                <th>Amount</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">View paymsnts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Tower name</label>
                                <input type="text" class="form-control" placeholder="Enter email address here" readonly
                                    name="tower_id" id="tower_id" value="{{ old('tower_id') }}">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputUsername1">Floor name</label>
                                <input type="text" class="form-control" placeholder="Enter email address here" readonly
                                    name="floor_id" id="floor_id" value="{{ old('floor_id ') }}">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputUsername1">Home name</label>
                                <input type="text" class="form-control" placeholder="Enter email address here" readonly
                                    name="home_id" id="home_id" value="{{ old('home_id') }}">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputUsername1">Customer NIC Number</label>
                                <input type="text" style="font-weight:bold" readonly class="form-control" id="cus_nic"
                                    name="cus_nic" placeholder="Enter customer NIC Here" value="{{ old('cus_nic') }}">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Customer Name</label>
                                <input type="text" class="form-control" placeholder="Enter Customer name here" readonly
                                    name="cus_name" id="cus_name" value="{{ old('cus_name') }}">

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Email address</label>
                                <input type="text" class="form-control" placeholder="Enter email address here" readonly
                                    name="cus_email" id="cus_email" value="{{ old('cus_email') }}">
                            </div>

                            <input type="hidden" class="form-control" id="cus_id" name="cus_id">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Payment Date</label>
                                <input type="date" class="form-control" readonly id="exampleInputUsername1"
                                    placeholder="Enter customer name here" name="pay_date" value="{{ old('pay_date') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputUsername1">Payment Slip</label>
                            </div>
                            <img id="image" src="" width="110px" style="margin-top:-10px" />
                            <br />
                            <br />

                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Payment Amount</label>
                                <input type="number" class="form-control" readonly id="exampleInputConfirmPassword1"
                                    placeholder="Enter tower location here" name="pay_amount"
                                    value="{{ old('pay_amount') }}">

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
                ajax: "{{ url('geAllPaymentsData') }}",
                "columns": [{
                        "data": "id"
                    }, {
                        "data": "tower_name"
                    },
                    {
                        "data": "floor_number"
                    },
                    {
                        "data": "home_number"
                    },
                    {
                        "data": "cus_name"
                    },
                    {
                        "data": "pd_collection_date"
                    },
                    {
                        "data": "pd_amount"
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
                                '<a href="payments/' + row.id + '/edit"><button  data-id=' + row
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
                    url: "{{ url('payments') }}/" + $id,
                    type: "get",
                    dataType: "json",
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {

                        $('input[name="tower_id"]').val(response.data.tower.tower_name);
                        $('input[name="floor_id"]').val(response.data.floor.floor_number);
                        $('input[name="home_id"]').val(response.data.home.home_number);
                        $('input[name="cus_nic"]').val(response.data.customer.cus_nic);
                        $('input[name="cus_name"]').val(response.data.customer.cus_name);
                        $('input[name="cus_email"]').val(response.data.customer.cus_email);
                        $('input[name="pay_date"]').val(response.data.pd_collection_date);
                        $('input[name="pay_amount"]').val(response.data.pd_amount);
                        $("textarea#cus_address").val(response.data.cus_address);
                        $('#image').attr('src', "/uploads/payments/" + response.data
                            .pd_recipt + "");

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
                        url: "{{ url('/payments') }}/" + $id,
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
            } else if (response == "insert") {
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
