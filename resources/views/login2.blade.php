<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Agro</title>
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
    </head>

    <body>
        <main>


            <section class="content-main  ">
                <h3 class="text-center m-3">Project Name</h3>
                <div class="card mx-auto card-login">


                    <div class="card-body">
                        <h4 class="card-title mb-4">Sign in</h4>
                        <form method="POST"  action="" >
                            @csrf

                            <div class="text-center">

                            </div>



                            <div class="mb-3 mt-3">
                                <input class="form-control" equired  name="name"  placeholder="Username " type="text" />
                            </div>
                            <!-- form-group// -->
                            <div class="mb-3">
                                <input class="form-control" required  name="password" placeholder="Password" type="password" />
                            </div>
                            <!-- form-group// -->
                            <div class="m-3">
                                <a href="" class="float-end font-sm text-muted mb-4">Forgot password?</a>
                                <label class="form-check">
                                    <input type="checkbox" name="remember_me" class="form-check-input" checked="" />
                                    <span class="form-check-label">Remember</span>
                                </label>
                            </div>
                            <!-- form-group form-check .// -->
                            <div class="m-4">
                                <button type="submit" class="btn btn-primary w-100 ">Login</button>
                            </div>
                            <!-- form-group// -->
                        </form>


                    </div>
                </div>
            </section>
            <footer class="main-footer text-center">
                <p class="font-xs">
                    <script>
                        document.write(new Date().getFullYear());
                    </script>

                </p>
                <p class="font-xs mb-30">All rights reserved</p>
            </footer>
        </main>
        <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
        <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
        <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
        <!-- Main Script -->
        <script src="assets/js/main.js?v=1.1" type="text/javascript"></script>
    </body>
</html>
