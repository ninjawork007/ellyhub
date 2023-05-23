@extends('layouts.web')
@section('pagebodyclass')
full-width white-bg @endsection
@section('content')
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Order Detail
</nav>
<div class="content-area" id="primary">
    <main class="site-main" id="main">
        <section class="section--wishlist">
            
            <div class="order-guest">
          
                <h2 class="page__title">Running orders</h2>
                <div class="wishlist__content">
                    <div class="wishlist__product">
                        <div class="wishlist__product--desktop">
                            @if(count($orders))
                            <table class="shop_table cart wishlist_table table table-bordered ">
                                <thead class="wishlist__thead">
                                    <tr>
                                        <!-- <th scope="col"></th> -->
                                        <th scope="col">Order Id</th>
                                        <th scope="col">Total Paid</th>
                                        <th scope="col">Total Products</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Order Status</th>
                                    </tr>
                                </thead>
                                <tbody class="wishlist__tbody">
                                    @foreach($orders as $key)
                                    <tr id="{{$key->order_id}}">
                                        <!-- <td>
                                            <div class="wishlist__trash"><i class="icon-trash2"></i></div>
                                        </td> -->
                                        <td><a
                                                href="{{route('order_detail',[base64_encode($key->order_id)])}}">{{$key->order_id}}</a>
                                        </td>
                                        <td>₹{{$key->after_discount_paid_by_customer}}</td>
                                        <td>{{$key->total}}</td>
                                        <td>{{$key->payment_method}}</td>
                                        <td>{{$key->payment_status}}</td>
                                        <td>{{$key->order_status}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-center">
                                <img src="{{url('/public/not-found.jpg')}}">
                                <p>No Order Found.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            

                <h2 class="page__title">Complete orders</h2>
                <div class="wishlist__content">
                    <div class="wishlist__product">
                        <div class="wishlist__product--desktop">
                            @if(count($completed))
                            <table class="table table-bordered table-package js-scrollable scroll-hint is-scrollable" style="position: relative;overflow: auto;width: 100%;">
                                <thead class="wishlist__thead">
                                    <tr>
                                        <!-- <th scope="col"></th> -->
                                        <th scope="col">Order Id</th>
                                        <th scope="col">Total Paid</th>
                                        <th scope="col">Total Products</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Order Status</th>
                                    </tr>
                                </thead>
                                <tbody class="wishlist__tbody1">
                                    @foreach($completed as $key)
                                    <tr id="{{$key->order_id}}">
                                        <!-- <td>
                                            <div class="wishlist__trash"><i class="icon-trash2"></i></div>
                                        </td> -->
                                        <td data-title="OrderID" class="order-id"><a
                                                href="{{route('order_detail',[base64_encode($key->order_id)])}}">{{$key->order_id}}</a>
                                        </td>
                                        <td data-title="Price" class="product-price">₹{{$key->after_discount_paid_by_customer}}</td>
                                        <td>{{$key->total}}</td>
                                        <td>{{$key->payment_method}}</td>
                                        <td>{{$key->payment_status}}</td>
                                        <td>{{$key->order_status}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-center">
                                <img src="{{url('/public/not-found.jpg')}}">
                                <p>No Order Found.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

@endsection