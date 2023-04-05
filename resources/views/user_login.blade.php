@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
    <meta name="google-signin-client_id" content="484485339160-ld4bs2mbnljosj4ntj2432euq588bhc9.apps.googleusercontent.com">
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Login
</nav>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin">
                        <div class="card-body registration__info">
                            <h5 class="card-title text-center">Sign In</h5>
                            @include('alerts')
                            <div class="error_"></div>
                            @if (Session::has('info'))
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h6><i class="icon fa fa-warning"></i><a
                                        href="{{url('user/resend-email')}}/{{Session::get('email')}}"
                                        class="resend_email">Click
                                        here</a> for resend email.</h6>
                            </div>
                            @endif
                            <form method="post" action="{{route('user_do_login')}}" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="type" value="customer">
                                <div class="form-label-group  mb-3">
                                    <label for="inputEmail">Email address</label>
                                    <input class="form-control" type="email" placeholder="Enter Email" name="email"
                                        required="" data-parsley-trigger="change" value="{{old('email')}}" autofocus>
                                </div>

                                <div class="form-label-group  mb-3">
                                    <label for="inputPassword">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        required="" placeholder="Password">
                                </div>

                                <div class="custom-checkbox mb-3">
                                    <label class="custom-control-label" for="customCheck1">
                                        <input type="checkbox" class="" id="customCheck1">
                                        Remember password</label>
                                </div>
                                <button class="btn ps-button btn-lg btn-primary btn-block text-uppercase  mb-3"
                                    type="submit">Sign
                                    in</button>
                                <div class="login__conect">
                                    <hr><p>Or login with</p><hr>
                                </div>
                                <a class="login-btn login-btn-facebook" onclick="fbLogin()"> Login with Facebook</a><br>
                                <!-- <a class="login-btn login-btn-google" id="googleSignIn" type="button" href="{{url('google/redirect')}}">Login with Google</a> -->
                                 <!-- <div id="my-signin2"></div> -->
                                <p>Not have account? <b><a class="main-color" href="{{url('/user/register')}}">Register here</a></b></p>
                                <p>Forget Password? <b><a class="main-color" href="{{url('/user/forget-password')}}">click here</a></b></p>
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
<script>
window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '3803386059757478', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v10.0' // use graph api version 2.8
    });
    
    // Check whether the user already logged in
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //display user data
            //getFbUserData();
        }
    });
};

// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

// Fetch the user profile data from facebook
function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
    function (response) {
        if (typeof response.email == 'undefined') {
            $('.error_').html("<div class='alert alert-danger' role='alert'>It seems your facebook don't has email id. please register with email address.</div>");
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        }
        
        type = 'fb';
        email = response.email;
        name = response.first_name;
        $.ajax({
            url:"{{route('login_with_facebook')}}",
            data:{type:type,email:email,name:name},
            cache:false,
            success:function(response){
                var ress = JSON.parse(response);
                if (ress.success) {
                    window.location.href="{{url('/account')}}";
                }else{
                    $('.error_').html('<div class="alert alert-warning" role="alert">'+ress.message+'</div>');
                }
            }
        });
    });
}

// Logout from facebook
function fbLogout() {
    FB.logout(function() {
        window.location.href="{{url('/')}}";
    });
}
// google login script
function onSuccess(googleUser) {
      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    }
    function onFailure(error) {
      console.log(error);
    }
    function renderButton() {
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onclick': onSuccess,
        'onfailure': onFailure
      });
    }
</script>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
@endsection