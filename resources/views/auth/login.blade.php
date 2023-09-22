
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{env('APP_NAME')}} - Login</title>
        <link href="{{url('/')}}/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{url('/')}}/assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                                <!-- Social login form-->
                                <div class="card my-5">
                                    <div class="card-body p-5 text-center">
                                        <h1>{{ env('APP_NAME') }}</h1>
                                        <p class="m-0">{{ env('APP_DESCRIPTION') }}</p>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body p-5">
                                        @if(session('alert'))
                                        <div class="alert alert-{{ session('alert')['type'] }} bg-{{ session('alert')['type'] }} alert-dismissible fade show" role="alert">
                                            <div class="text-white">{{ session('alert')['message'] }}</div>
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @endif
                                        <!-- Login form-->
                                        <form action="{{route('auth.doLogin')}}" method="POST">
                                            @csrf
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="text-gray-600 small" for="inputUsername">Username</label>
                                                <input class="form-control form-control-solid" type="text" placeholder="Enter Username" name="username" aria-describedby="inputUsername" />
                                            </div>
                                            <!-- Form Group (password)-->
                                            <div class="mb-3">
                                                <label class="text-gray-600 small" for="inputPassword">Password</label>
                                                <input class="form-control form-control-solid" type="password" placeholder="Enter Password" name="password" aria-label="Password" aria-describedby="inputPassword" />
                                            </div>
                                            <!-- Form Group (login box)-->
                                            <div class="d-flex align-items-center justify-content-between mb-0">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="checkRememberPassword" type="checkbox" name="remember" value="" />
                                                    <label class="form-check-label" for="checkRememberPassword">Remember password</label>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr class="my-0" />
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto footer-dark">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; Your Website {{date('Y')}}</div>
                            <div class="col-md-6 text-md-end small">
                                <a href="#!">Privacy Policy</a>
                                &middot;
                                <a href="#!">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{url('/')}}/js/scripts.js"></script>
    </body>
</html>
