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
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="login-div">
                <nav>
                <div class="nav nav-tabs div-tab" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sign Up</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Log In</button>
                </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <h4>Create an Ellyhub Account</h4>
                    <div class="row">
                        <div class="row-input-div col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name">
                        </div>
                        <div class="row-input-div col-md-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-input-div col-md-12">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-input-div col-md-12">
                            <label for="email">Email Confirmation</label>
                            <input type="text" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-input-div col-md-12">
                            <label for="email">Password</label>
                            <input type="text" class="form-control" aria-describedby="passwordhelp" id="email">
                            <small id="passwordhelp" class="form-text text-muted">(at least 8 characters)</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-input-div col-md-12">
                            <button type="button"  aria-describedby="signupterms" class="btn btn-light">Sign Up</button>
                            <small id="signupterms"  class="form-text text-muted">This site is protected by reCAPTCHA Enterprise and Google <span class="link-blue">Privacy Policy</span> and <span class="link-blue"> Terms of Service </span> apply.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-check col-md-12">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked>
                            <label class="form-check-label" for="flexCheckChecked">By clicking Sign Up, I expressly agree to accept Ellyhub's<span class="link-blue">Terms of Use</span> and <span class="link-blue">Privacy Policy</span> <span class="required-span">REQUIRED</span>
                            </label>
                        </div>
                    </div>
                    <p class="h4-hor">OR</p>
                    <div class="row">
                        <div class="row-input-div col-md-12">
                            <button type="button" class="btn btn-light">Sign Up with Google</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-input-div col-md-12">
                            <button type="button" class="btn btn-light">Sign Up with Apple</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-input-div col-md-12">
                            <button type="button" class="btn btn-blue">Sign Up with Facebook</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0"></div>
                </div>
            </div>
        </div>
    </div>
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