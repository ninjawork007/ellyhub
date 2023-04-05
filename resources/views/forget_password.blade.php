@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Forget Password
</nav>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin">
                        <div class="card-body registration__info">
                            <h5 class="card-title text-center">Forget Password</h5>
                            @include('alerts')
                            <div class="error_"></div>
                            <form method="post" action="{{route('send_password')}}" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="type" value="{{$type}}">
                                <div class="form-label-group  mb-3">
                                    <label for="inputEmail">Email address</label>
                                    <input class="form-control" type="email" placeholder="Enter Email" name="email"
                                        required="" data-parsley-trigger="change" value="{{old('email')}}" autofocus>
                                </div>
                                <button class="btn ps-button btn-lg btn-primary btn-block text-uppercase  mb-3" type="submit">Reset Password</button>
                                
                                <p>Login? <b><a class="main-color" href="{{url('/user/login')}}">click here</a></b></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection