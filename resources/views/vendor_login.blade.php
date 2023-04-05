@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span>Vendor Login
</nav>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin">
                        <div class="card-body registration__info">
                            <h5 class="card-title text-center">Vendor Log In</h5>
                            @include('alerts')
                            @if (Session::has('info'))
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h6><i class="icon fa fa-warning"></i><a
                                        href="{{url('vendor/resend-email')}}/{{Session::get('email')}}"
                                        class="resend_email">Click here</a> for resend email.</h6>
                            </div>
                            @endif
                            <form method="post" action="{{route('vendor_login')}}" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="type" value="vendor">
                                <div class="form-label-group  mb-3">
                                    <label for="inputEmail">Email address</label>
                                    <input class="form-control" type="email" placeholder="Enter Email " name="email" required="" data-parsley-trigger="change" value="{{old('email')}}">
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Password</label>
                                    <input class="form-control" type="password" name="password" id="password" required="" placeholder="Password">
                                </div>

                                <div class="custom-checkbox mb-3">
                                    <label class="custom-control-label" for="customCheck1">
                                        <input type="checkbox" class="" id="customCheck1">
                                        Remember password</label>
                                </div>
                                <button class="btn ps-button btn-lg btn-primary btn-block text-uppercase mb-3" type="submit">Sign in</button>
                                <p>Not have account? <b><a class="main-color" href="{{url('/vendor/register')}}">Register here</a></b></p>
                                <p>Forget Password? <b><a class="main-color" href="{{url('/vendor/forget-password')}}">click here</a></b></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script type="text/javascript">
$('body').on('click', '.resend_email', function() {
    alert($('input[name="email"]').val());
});
</script>
@endsection