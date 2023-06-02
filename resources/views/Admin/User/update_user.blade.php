@extends('layout.app')

@section('content')
    <div class="page-header" style="margin-top: -15px;margin-bottom: 15px">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>User</h5>
                        <span>update user</span>
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
                    <form class="forms-sample" action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">User name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter name here"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{$user->name}}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div>
                                    <button type="submit" class="btn btn-warning mr-2">Update</button>
                                    {{-- <button class="btn btn-light">Cancel</button> --}}
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Email Address</label>
                                    <input class="form-control" id="email" type="email"
                                        placeholder="Enter email address here"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{$user->email}}" required autocomplete="email">


                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>
                        </div>


                </div>
                </form>

            </div>
        </div>
    </div>
@endsection
