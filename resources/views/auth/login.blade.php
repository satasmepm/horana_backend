<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Horana heights</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg" />
    <!-- Template CSS -->
    <link href="assets/css/main.css?v=1.1" rel="stylesheet" type="text/css" />
    <style>

    </style>
</head>

<body>
    <main>
        <section class="content-main  ">
            <h2 class="text-center m-3">Horana Heights</h2>
            <div class="card mx-auto card-login">
                <div class="card-body">
                    <center>
                        {{-- <p style="padding-top: 20px;font-size: 3.3em;color: #ffffff;font-family: 'Quicksand', sans-serif;">BXL login</p> --}}
                        <p style="padding-top: 0px">
                            <img style="width:140px" src="{{ asset('images/res_img/Lock.png') }}">
                        </p>
                        <h4 class="card-title mb-4">Welcome back</h4>
                        <p style="margin-top: -32px;font-size: 0.9em;font-family: 'Quicksand', sans-serif;">Welcome back!. Please enter your details</p>
                    </center>

                    <form method="POST" action="">
                        @csrf
                        <div class="text-center">
                        </div>
                        <div class="mb-3 mt-3">
                            <input equired id="email" type="email" placeholder="Username "
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus />
                        </div>
                        @error('email')
                            <span class="text-danger error-text">
                                {{ $message }}
                            </span>
                        @enderror
                        <!-- form-group// -->
                        <div class="mb-3">
                            <input id="password" type="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" />
                        </div>
                        @error('password')
                            <span class="text-danger error-text">
                                {{ $message }}
                            </span>
                        @enderror
                        <!-- form-group// -->
                        <div class="m-3">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="float-end font-sm text-muted mb-4">Forgot password?</a>
                            @endif
                            <label class="form-check">
                                <input type="checkbox" name="remember_me" class="form-check-input" checked="" />
                                <span class="form-check-label">Remember</span>
                            </label>
                        </div>
                        <!-- form-group form-check .// -->
                        <div class="mb-3 mt-3">
                            <button type="submit" class="btn btn-primary w-100 ">Login</button>
                        </div>
                        <!-- form-group// -->
                    </form>
                </div>
            </div>
        </section>
        <footer class="main-footer text-center">
            {{-- <span class="font-xs">
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p> --}}
            <p class="font-xs mb-30">Copyright © 2023 Satasme holdings (PVT) Ltd. All Rights Reserved.</p>
        </footer>
    </main>
    <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <!-- Main Script -->
    <script src="assets/js/main.js?v=1.1" type="text/javascript"></script>
</body>

</html>
