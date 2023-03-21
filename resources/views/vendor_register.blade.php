@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span>Vendor Register
</nav>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin">
                        <div class="card-body registration__info">
                            <h5 class="card-title text-center">Vendor Registration</h5>
                            <p>Get started by just filling out one simple form</p>
                            @include('alerts')
                            <p class="main-color"><b>Business Information</b></p>
                            <form method="post" action="{{route('register_form_save')}}" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="type" value="vendor">
                                <div class="form-label-group  mb-3">
                                    <label for="inputEmail">Name</label>
                                    <input class="form-control" type="text" placeholder="Enter Business Owner Name" name="name" required="">
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Email</label>
                                    <input class="form-control" type="email" placeholder="Enter Email " name="email" required="" data-parsley-trigger="change">
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Password</label>
                                    <input class="form-control" type="password" name="password" id="password" required="">
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Retype Password</label>
                                    <input class="form-control" type="password" name="re_password" data-parsley-equalto="#password" required="" data-parsley-trigger="change">
                                </div>
                                <div class="form-label-group  mb-3">
                                    <p>By creating an account, you agree to Farmart's <b><a class="main-color" href="#}">Conditions of Use</a></b> and <b><a class="main-color" href="#}">Privacy Notice</a></b>.</p>
                                </div>
                                <button class="btn ps-button btn-lg btn-primary btn-block text-uppercase  mb-3" type="submit">Register</button>
                                <p>Do you have account? <b><a class="main-color" href="{{url('/vendor/login')}}">Login</a></b></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection