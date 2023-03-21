@extends('layouts.web')
@section('content')
<main class="no-main">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="ps-breadcrumb__list">
                    <li class="active"><a href="{{url('/')}}">Home</a></li>
                    <li><a href="javascript:void(0);">Verification</a></li>
                </ul>
            </div>
        </div>
        <section class="section--registration">
            <div class="container">
                <h2 class="page__title">{{$message}}</h2>
                <div class="registration__content">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 text-center">
                            <img src="{{$image}}" class="verify_image" style="width: 20%;">
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    @if($success)
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 text-center">
                            <a href="{{url('/')}}" class="btn">Home</a>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection