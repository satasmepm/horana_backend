@extends('Layout.app')
@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-inbox bg-blue"></i>
                    <div class="d-inline">
                        <h5>Asign homes</h5>
                        <span>view asign homes to cusromer</span>
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
                                <th>Tower Name</th>
                                <th>Floor number</th>
                                <th>Home number</th>
                                <th class="nosort">Customer name</th>

                                <th>Status</th>
                                <th style="width:150px">Actions</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">View details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="exampleInputUsername1">Tower name</label>
                                <input type="text" class="form-control" id="tower_name"readonly placeholder=""
                                    name="tower_name" value="{{ old('tower_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Floor number</label>
                                <input type="text" class="form-control" id="floor_name" readonly
                                    placeholder="Enter address here" name="floor_name" value="{{ old('floor_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Home number</label>
                                <input type="text" class="form-control" id="home_number"
                                    placeholder="Enter phone number here" name="home_number"readonly
                                    value="{{ old('home_number') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Customer name</label>
                                <input type="text" class="form-control" id="cus_name"
                                    placeholder="Enter phone number here" name="cus_name"readonly
                                    value="{{ old('cus_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">NIC number</label>
                                <input type="text" class="form-control" id="cus_nic"
                                    placeholder="Enter phone number here" name="cus_nic"readonly
                                    value="{{ old('cus_nic') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email address</label>
                                <input type="text" class="form-control" id="cus_email"
                                    placeholder="Enter phone number here" name="cus_email"readonly
                                    value="{{ old('cus_email') }}">
                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Down payment</label>
                                <input type="number" class="form-control" id="ah_down_payment" placeholder=""
                                    name="ah_down_payment"readonly value="{{ old('ah_down_payment') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Asinged date</label>
                                <input type="text" class="form-control" id="ah_reserve_date" placeholder=""
                                    name="ah_reserve_date"readonly value="{{ old('ah_reserve_date') }}">
                            </div>
                            <img id="image" src="" width="110px" style="margin-top:-10px" />
                            <div class="form-group">
                                <label for="exampleInputPassword1">Recipt</label>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Remark</label>
                                <textarea type="text" class="form-control" id="ah_remark" placeholder="Enter address here" name="ah_remark"
                                    value="{{ old('ah_remark') }}" rows="3"></textarea>

                            </div>
                            <div class="form-group">
                                <label for="">Payment Type</label>
                                <select name="payment_type" id="payment_type" class="form-control">
                                    <option value="">Select an option</option>
                                    <option value="1">Open</option>
                                    <option value="2">Defaulted</option>
                                    <option value="3">----Fraud</option>
                                    <option value="4">----Investigation</option>
                                    <option value="5">----Legal</option>
                                    <option value="6">Denied</option>
                                </select>
                                <span class="text-danger error-text payment_type_error"></span>
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
                ajax: "{{ url('geAllAsignHomesData') }}",
                "columns": [{
                        "data": "id"
                    }, {
                        "data": "tower.tower_name"
                    },
                    {
                        "data": "floor.floor_number"
                    },
                    {
                        "data": "home.home_number"
                    },
                    {
                        "data": "customer.cus_name"
                    }, {
                        "data": null,
                        render: function(data, type, row) {
                            if (row.types.id == 1) {
                                return '<span class="badge badge-pill badge-success mb-1">Open</span>';
                            } else if (row.types.id == 2) {
                                return '<span class="badge badge-pill badge-warning mb-1">Defaulted</span>';
                            } else if (row.types.id == 3) {
                                return '<span class="badge badge-pill badge-warning mb-1">Fraud</span>';
                            } else if (row.types.id == 4) {
                                return '<span class="badge badge-pill badge-warning mb-1">Investigation</span>';
                            } else if (row.types.id == 5) {
                                return '<span class="badge badge-pill badge-warning mb-1">Legal</span>';
                            } else if (row.types.id == 6) {
                                return '<span class="badge badge-pill badge-danger mb-1">Denied</span>';
                            }else if (row.types.id == 7) {
                                return '<span class="badge badge-pill badge-primary mb-1">Closed</span>';
                            }
                        }
                    }, {
                        "data": null,
                        render: function(data, type, row) {
                            return '<button style="margin-right:5px" data-id=' + row.id +
                                ' class="btn btn-sm   btn-light" data-toggle="modal" data-target="#exampleModalLong" id="view"><i class="ik ik-eye"></i></button>' +
                                '<a href="asign_home/' + row.id + '/edit"><button  data-id=' + row
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
                    url: "{{ url('asign_home') }}/" + $id,
                    type: "get",
                    dataType: "json",
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {

                        $('input[name="tower_name"]').val(response.data.tower.tower_name);
                        $('input[name="floor_name"]').val(response.data.floor.floor_number);
                        $('input[name="home_number"]').val(response.data.home.home_number);
                        $('input[name="cus_name"]').val(response.data.customer.cus_name);
                        $('input[name="cus_nic"]').val(response.data.customer.cus_nic);
                        $('input[name="cus_email"]').val(response.data.customer.cus_email);
                        $('input[name="ah_down_payment"]').val(response.data.ah_down_payment);
                        $('input[name="ah_reserve_date"]').val(response.data.ah_reserve_date);
                        $('#image').attr('src', "/uploads/asign_homes/" + response.data
                            .ah_reserve_recipt + "");
                        $('#ah_remark').val(response.data.ah_remark);
                        $('select[name="payment_type"]').val(response.data.ah_type);
                        // $('input[name="cus_nic"]').val(response.data.cus_name);
                        // $('input[name="cus_phone"]').val(response.data.cus_phone);
                        // $('input[name="cus_email"]').val(response.data.cus_email);
                        // $("textarea#cus_address").val(response.data.cus_address);


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
                        url: "{{ url('/asign_home') }}/" + $id,
                        type: "DELETE",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            table.ajax.reload();
                            alert("sdasdasd");
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
