@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> My Profile
</nav>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="section--wishlist">
            <div class="container">
                @include('common.alerts')
                <div class="row">

                    <div class="col-12 col-lg-5">
                        <div class="card p-3">
                            <div class="d-flex align-items-center">
                                <div class="image">
                                    @if(Auth::user()->image)
                                    <img src="{{url('public/'.Auth::user()->image)}}" class="rounded" width="155">
                                    @else
                                    <img src="https://www.atmeplay.com/images/users/avtar/avtar_nouser.png"
                                        class="rounded" width="155">
                                    @endif
                                </div>
                                <div class="ml-3 w-100">
                                    <h4 class="mb-0 mt-0">{{Auth::user()->name}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="checkout__form">
                            <form method="post" data-parsley-validate="" action="{{route('update_profile')}}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="col-12 col-lg-6 form-group--block">
                                        <label>Name: <span>*</span></label>
                                        <input class="form-control" type="text" required=""
                                            value="{{Auth::user()->name}}" name="name">
                                    </div>
                                    <div class="col-12 col-lg-6 form-group--block">
                                        <label>Email<span>*</span></label>
                                        <input class="form-control" type="email" required=""
                                            value="{{Auth::user()->email}}" name="email" readonly="">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Mobile</label>
                                        <input class="form-control" type="text" value="{{Auth::user()->mobile}}"
                                            name="mobile" required="">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Profile</label>
                                        <input class="form-control" type="file" name="file">
                                    </div>
                                    <button class="checkout__order"> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</div>
@endsection