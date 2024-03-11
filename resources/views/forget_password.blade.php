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
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="login-div">
                <div class="tab-content" id="nav-tabContent">
                    <form method="post" action="{{route('send_password')}}" data-parsley-validate="">
                    @csrf
                        <div class="tab-pane show active fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                            <h2>Password Reset</h2>
                            <p class="text-class">Enter your email address and we'll send you a link to reset your password.</a></p>
                            <div class="row">
                            <input type="hidden" name="type" value="{{$type}}">
                                <div class="row-input-div col-md-12">
                                    <label for="email">Your Email</label>
                                    <input required value="{{old('email')}}" type="text" class="form-control" name="email" id="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="row-input-div col-md-12">
                                    <button type="submit"  aria-describedby="signupterms" class="btn btn-light">Send Password Reset Email</button>
                                </div>
                            </div>
                            <p class="forgot-pass">If you need help, just <a class="link-blue" href="{{url('/user/forget-password')}}">let us know</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection