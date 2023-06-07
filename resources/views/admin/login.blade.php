<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Login || amrkart - Multivendor Market Place</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{url('assets/web/images/favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{url('assets/web/images/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{url('assets/web/images/favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{url('assets/web/images/favicon/site.webmanifest')}}">
  <link rel="mask-icon" href="{{url('assets/web/images/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="{{url('assets/parsley/parsley.css')}}">
  <link rel="stylesheet" href="{{url('assets/adminn/vendors/datatables/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{url('assets/adminn/css/app.min.css')}}">
  <script src="{{url('assets/adminn/js/jquery.min.js')}}"></script>
</head>

<body>
  <div class="app">
    <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('{{url('assets/adminn/images/others/login-3.png')}}')">
      <div class="d-flex flex-column justify-content-between w-100">
        <div class="container d-flex h-100">
          <div class="row align-items-center w-100 m-0">
            <div class="col-md-7 col-lg-5 m-h-auto p-0">
              <div class="card shadow-lg">
                <div class="card-body">
                  <div class="logo text-center m-b-20">
                    <img class="img-fluid" alt="" src="{{url(''.$setting[0]->logo)}}" style="max-width:150px">
                  </div>
                  @include('alerts')
                  <form class="pt-3" method="post" data-parsley-validate="" action="{{route('attempt_login')}}">
                    @csrf
                    <div class="form-group">
                      <label class="font-weight-semibold" for="userName">Username:</label>
                      <div class="input-affix">
                        <i class="prefix-icon anticon anticon-user"></i>
                        <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="font-weight-semibold" for="password">Password:</label>
                      <div class="input-affix m-b-10">
                        <i class="prefix-icon anticon anticon-lock"></i>
                        <input type="password" class="form-control form-control-lg" placeholder="Password" name="password" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-affix m-b-10">
                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Sign In</button>
                      </div>
                      <div class="text-center">
                        <a href="#" class="font-size-13 text-muted">Forgot password?</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="d-none d-md-flex p-h-40 justify-content-between">
          <span class="">&copy; <?php echo date("Y"); ?> amrkart.com</span>
        </div>
      </div>
    </div>
  </div>
  <script src="{{url('assets/adminn/js/vendors.min.js')}}"></script>
  <script src="{{url('assets/parsley/parsley.js')}}"></script>
  <script type="text/javascript" src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="{{url('assets/adminn/js/app.min.js')}}"></script>
</body>

</html>