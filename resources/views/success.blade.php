@extends('layouts.web')

@section('content')
<main class="no-main">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="ps-breadcrumb__list">
                    <li class="active"><a href="{{url('/')}}">Home</a></li>
                    <li><a href="javascript:void(0);">success</a></li>
                </ul>
            </div>
        </div>
        <section class="section--shopping-cart">
            <div class="container shopping-container">
                <div class="shopping-cart__content">
                   <div class="row m-0">
                        <div class="col-md-12 notfound text-center">
                            <img src="{{url('public/success.gif')}}" width="200px">
                            <br>
                            <p>Order successfull Placed</p>
                            <a class="btn" href="{{url('/orders')}}">Go To Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

