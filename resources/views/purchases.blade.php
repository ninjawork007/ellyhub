@extends('layouts.web')
@section('pagebodyclass')
full-width @endsection
@section('content')
<div id="primary" class="content-area">
    <main id="main" class="site-main container purchases">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-md-3">
                <h2 class="text-black">Purchases</h2>
            </div>
            <div class="col-lg-5 col-md-5">
                <form>
                    <div class="row justify-content-end">
                        <div class="col-md-8 position-relative">
                            <button type="reset" class="reset_button">&times;</button>
                            <input type="text" name="search_orders" placeholder="Search your orders" class="form-control input-lg"/>
                        </div>
                        <div class="col-md-3">
                            <button type="button" name="Search" class="btn btn-blue">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6">
                <div class="filters container">
                    <ul class="all-filter">
                        <li><a class="remove-filter show-filters {{(Request::is('purchases') ? 'active' : '')}}" href="{{url('purchases')}}">All Purchases</a></li>
                        <li><a class="remove-filter show-filters {{(Request::is('purchases/pending') ? 'active' : '')}}" href="{{url('purchases/pending')}}">Processing</a></li>
                        <li><a class="remove-filter show-filters {{(Request::is('purchases/return_canceled') ? 'active' : '')}}" href="{{url('purchases/return_canceled')}}">Returns & Canceled</a></li>
                    </ul>
                </div>
                <div class="filters container">
                    <ul class="all-filter">
                        <li><a class="remove-filter show-filters {{(Request::is('purchases/ready_for_feedback') ? 'active' : '')}}" href="{{url('purchases/ready_for_feedback')}}">Ready For Feedback</a></li>
                        <li><a class="remove-filter show-filters {{(Request::is('purchases/dispatch') ? 'active' : '')}}" href="{{url('purchases/dispatch')}}">Shipped</a></li>
                        <li><a class="remove-filter show-filters {{(Request::is('purchases/failed') ? 'active' : '')}}" href="{{url('purchases/failed')}}">Payment Failed</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-lg-2">
            </div>
        </div>

        <div class="orders">
            <div class="row">
                <div class="col-md-6"><h3 class="text-black">Orders</h3></div>
                <div class="col-md-6 text-end"><h5 class="text-black">See orders: <i class="fa fa-angle-down"></i></h5></div>
            </div>
            @foreach($orders as $purchases)
            <div class="row mb-3">
                <div class="col-md-3">
                    <?php
                    if(strpos('http', $purchases->image) !== false){
                        $url = $purchases->image;
                    }
                    else{
                        $url = url('public/'.$purchases->image);
                    }
                    ?>
                    <div class="background-image-purchase" style="background-image:url('{{$url}}')"></div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <h5 class="text-black mb-0">Delivered</h5>
                            <p class="text-black mb-0">Order Date: {{date('M d, Y', strtotime($purchases->created_at))}}</p>
                            <p class="text-black mb-0">Order Total: <b class="text-black">US ${{number_format($purchases->order_total, 2)}}</b></p>
                            <p class="text-black">Order Number: {{$purchases->order_id}}</p>

                            <p class="text-black mb-0 fw-bolder">Delivered on {{date('M d, Y', strtotime($purchases->modify_at))}}</p>
                            <p class="text-black mb-0">Returns accepted through {{date('M d', strtotime($purchases->modify_at))}}.</p>
                        </div>
                        <div class="col-md-7">
                            <p class="mb-0 text-green">Delivered on <b class="text-green">{{date('D M, Y', strtotime($purchases->modify_at))}}</b></p>
                            <div class="stepper-wrapper mt-3">
                                <div class="stepper-item">
                                    <div class="step-counter"><i class="fa fa-check text-white"></i></div>
                                    <div class="step-name">Paid</div>
                                    <p class="fw-normal text-black">{{date('M d', strtotime($purchases->modify_at))}}</p>
                                </div>
                                <div class="stepper-item">
                                    <div class="step-counter"><i class="fa fa-check text-white"></i></div>
                                    <div class="step-name">Shipped</div>
                                    <p class="fw-normal text-black">{{date('M d', strtotime($purchases->modify_at))}}</p>
                                </div>
                                <div class="stepper-item">
                                    <div class="step-counter"><i class="fa fa-check text-white"></i></div>
                                    <div class="step-name">Delivered</div>
                                    <p class="fw-normal text-black">{{date('M d', strtotime($purchases->modify_at))}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_info mt-4">
                        <p class="text-decoration-underline text-black mb-0">{{$purchases->product_name}}</p>
                        <p class="text-black">Quantity: {{$purchases->product_quantity}}</p>
                        <p class="text-black fw-bolder">US ${{$purchases->sale_price}}</p>

                        <p class="text-muted">
                            Sold by: <a href="{{url('vendor/'.$purchases->vendorid)}}" class="text-blue text-decoration-underline">{{$purchases->name}}</a>
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <a href="#" class="form-control btn btn-blue-outline">View order details</a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#feedback{{$purchases->id}}" class="form-control btn btn-blue">Leave feedback</a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="form-control btn btn-blue-outline">More actions <i class="fa fa-angle-down"></i></a>
                        </div>
                    </div>

                    <div class="modal fade" id="feedback{{$purchases->id}}" tabindex="-1" aria-labelledby="feedbackLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6 class="text-black fst-italic">Your satisfaction matters!</h6>

                                    <div class="happy">
                                        <p class="text-black fst-italic">Please let us know about your recent experience.<br>
                                        Did your purchase go smoothly (successful)?</p>

                                        <a href="{{url('feedback/happy/'.$purchases->id)}}" class="satisfaction satisfaction-happy"><img src="{{url('public/assets/web/images/smily.png')}}" class="img-fluid"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Successful</span></a>
                                    </div>

                                    <div class="or my-5 py-3">
                                        <p class="text-black fst-italic fw-bold">OR</p>
                                    </div>
                                    <div class="happy mb-4">
                                        <p class="text-black fst-italic">Did you encounter any issues that need attantion (unresolved issue)?<br>
                                        This option will give you, the seller, and Ellyhub a chance to resolve any issues.
                                        </p>

                                        <a href="{{url('feedback/sad/'.$purchases->id)}}" class="satisfaction satisfaction-sad"><img src="{{url('public/assets/web/images/sad.png')}}" class="img-fluid"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Unresolved Issue</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>
@endsection