@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Register
</nav>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin">
                        <div class="card-body registration__info">
                            <h5 class="card-title text-center">Registration</h5>
                            <p>Get started by just filling out one simple form</p>
                            @include('alerts')
                            <form method="post" action="{{route('user_register_form_save')}}" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="type" value="customer">
                                <div class="form-label-group  mb-3">
                                    <label for="inputEmail">Name</label>
                                    <input class="form-control" type="text" placeholder="Enter Name" name="name"
                                        required="">
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Email</label>
                                    <input class="form-control" type="email" placeholder="Enter Email " name="email"
                                        required="" data-parsley-trigger="change">
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Password</label>
                                    <input class="form-control" type="password" name="password" id="password"
                                        required="" placeholder="Enter Password">
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Retype Password</label>
                                    <input class="form-control" type="password" name="re_password"
                                            data-parsley-equalto="#password" required="" data-parsley-trigger="change"
                                            placeholder="Retype password">
                                </div>
                                <button class="btn ps-button btn-lg btn-primary btn-block text-uppercase  mb-3"
                                    type="submit">Register</button>
                                <p>Do you have account? <b><a class="main-color" href="{{url('/user/login')}}">Login</a></b></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection