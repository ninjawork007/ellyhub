@extends('layouts.web')
@section('pagebodyclass')
    full-width @endsection
@section('content')
<div id="primary" class="content-area">
    <main id="main" class="site-main container purchases">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-md-3">
                <h2 class="text-black">Order details</h2>
            </div>
            <div class="col-lg-5 col-md-5 text-end">
                <button class="btn btn-default text-black" id="btn_print" style="background-color: #F5F5F5;border-radius: 30px;"><i class="fa fa-print"></i> Printer friendly page</button>
            </div>
        </div>

        <div class="orders order_details row" id="print_div">
            <div class="col-md-8">
                <div class="border p-3">

                    @if($orders[0]->delivery_status=='delivered')
                        <div class="delivery_order mb-3" style="background-color: #f7f7f7;">
                            <div class="row p-4">
                                <div class="col-md-1">
                                    <?php
                                    if(strpos($orders[0]->image, 'http') !== false){
                                        $explode = explode(',', $orders[0]->image);
                                        $url = $explode[0];
                                    }
                                    else{
                                        $url = url('public/'.$orders[0]->image);
                                    }
                                    ?>
                                    <img src="{{$url}}" class="img-fluid">
                                </div>
                                <div class="col-md-10">
                                    <h6 class="mb-0 text-black">Your item was delivered.</h6>
                                    <p class="mb-0 text-black" style="font-size:13px;">Delivered on {{date('D, M Y', strtotime($orders[0]->modify_at))}}</p>
                                    @if(!empty($orders[0]->tracking_id))<a href="#" class="text-black text-decoration-underline fw-bold">Track package</a>@endif
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach($orders as $purchases)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <h4 class="text-black">Order Info</h4>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted">
                                            Time placed
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-black fw-bold">
                                            {{date('M d, Y \a\t h:i A', strtotime($purchases->created_at))}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted">
                                            Order Number
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-black fw-bold">
                                            {{$purchases->order_id}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted">
                                            Total
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-black fw-bold">
                                            ${{number_format($purchases->order_total, 2)}} ({{$count.' items'}})
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted">
                                            Sold by
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-black">
                                            <a href="{{url('vendor/'.$purchases->vendorid)}}" class="text-black fw-bold text-decoration-underline">{{$purchases->vendor_name}}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <h4 class="text-black">Delivery info</h4>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-0 text-green">Delivered on <b class="text-green">{{date('D M, Y', strtotime($purchases->modify_at))}}</b></p>
                                <div class="stepper-wrapper mt-3">
                                    <div class="stepper-item {{(!empty($purchases->is_payment_done)) ? 'completed' : ''}}">
                                        <div class="step-counter"><i class="fa fa-check text-white"></i></div>
                                        <div class="step-name">Paid</div>
                                        <p class="fw-normal text-black">{{date('M d', strtotime($purchases->created_at))}}</p>
                                    </div>
                                    <div class="stepper-item {{($purchases->delivery_status == 'dispatch' || $purchases->delivery_status == 'delivered') ? 'completed' : ''}}">
                                        <div class="step-counter"><i class="fa fa-check text-white"></i></div>
                                        <div class="step-name">Shipped</div>
                                        <p class="fw-normal text-black">{{($purchases->delivery_status == 'dispatch' || $purchases->delivery_status == 'delivered') ? date('M d', strtotime($purchases->dispatch_date)) : ''}}</p>
                                    </div>
                                    <div class="stepper-item {{($purchases->delivery_status == 'delivered') ? 'completed' : ''}}">
                                        <div class="step-counter"><i class="fa fa-check text-white"></i></div>
                                        <div class="step-name">Delivered</div>
                                        <p class="fw-normal text-black">{{($purchases->delivery_status == 'delivered') ? date('M d', strtotime($purchases->delivery_date)) : ''}}</p>
                                    </div>
                                </div>
                                @if(!empty($purchases->tracking_id))
                                    <div class="tracking_info">
                                        <h6 class="text-black">Tracking details</h6>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="text-muted">
                                                    Number
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-black fw-bold">
                                                    {{$purchases->tracking_id}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="#" class="btn btn-blue-outline ms-auto" style="border-radius: 30px;font-size:14px;background-color:transparent">Track package</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="items-info mb-5">
                            <h5 class="text-black">Item info</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <?php
                                    if(strpos($purchases->image, '//') !== false){
                                        $urlex = explode(',', $purchases->image);
                                        $url = $urlex[0];
                                    }
                                    else{
                                        $url = url('public/'.$purchases->image);
                                    }
                                    ?>
                                    <div class="background-image-purchase" style="background-image:url('{{$url}}')"></div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="text-black">{{$purchases->product_name}}</h6>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <h6 class="text-black fw-bold">${{number_format($purchases->product_price, 2)}}</h6>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-0" style="color:#7B7B7B;">
                                        <b style="color:#7B7B7B;">Item number: </b>{{$purchases->productid}}
                                    </p>
                                    <p class="text-muted mb-0" style="color:#7B7B7B;">
                                        <b style="color:#7B7B7B;">Quantity: </b>{{$purchases->product_quantity}}
                                    </p>
                                    <p class="text-muted mb-0" style="color:#7B7B7B;">
                                        Returns accepted through {{$purchases->product_quantity}} {{date('M d, Y')}}.
                                    </p>
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <a href="#" class="text-decoration-underline text-black fw-bold">Leave feedback</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="text-decoration-underline text-black fw-bold">Contact seller</a>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <a href="#" class="btn btn-blue-outline" style="border-radius:30px;font-size:14px;background-color:transparent">More actions <i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom mb-5"></div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="text-black">Shipping address</h4>

                <div class="p-3 text-black">
                    <p>{{$orders[0]->name}}<br>{{$orders[0]->street_address}}<br>
                    {{$orders[0]->city}}, {{$orders[0]->zip}}<br>
                    {{$orders[0]->country}}</p>
                </div>

                <h4 class="text-black">Payment info</h4>

                <div class="p-3 text-black">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <img src="{{url('public/assets/web/images/master_card.png')}}" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <p style="font-size:15px;" class="text-black mb-0">Ending in 1993</p>
                                    <p style="font-size:13px;" class="mb-0">{{$orders[0]->name}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 text-end">
                            <p style="font-size:15px;" class="text-black mb-0 fw-bold">${{number_format($orders[0]->order_total, 2)}}</p>
                            <p style="font-size:12px;" class="mb-0 text-muted">{{date('M d \a\t h:i A', strtotime($purchases->created_at))}}</p>
                        </div>
                    </div>

                    <div class="p-3 mt-4" style="background-color: #fbfbfb;border-radius: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <p>{{$count.' items'}}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="fw-bold">${{number_format($orders[0]->order_total, 2)}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Item discount</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="fw-bold text-green">${{($orders[0]->order_total - $orders[0]->after_discount_paid_by_customer)}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Shipping</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="fw-bold text-green">Free</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">Tax</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="fw-bold mb-0">$0</p>
                            </div>
                        </div>
                        <div class="border-bottom mt-3 mb-3"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0 fw-bold">Order total</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="fw-bold mb-0">${{number_format($orders[0]->order_total, 2)}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <p class="mb-0 text-black">How do you like our order details page?</p>
                    <a href="#" class="text-black text-decoration-underline">Tell us what you think</a>
                </div>
            </div>
        </div>
    </main>
</div>
    <script type="text/javascript">
        $("#btn_print").click(function() {
            var divToPrint = document.getElementById('print_div');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><head><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100;200,300,400,500,600,700,900">'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/bootstrap/css/bootstrap.min.css')}}" media="all" />'+
                    ' <link rel="stylesheet" href="{{url('public/assets/web/font-awesome/css/font-awesome.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/bootstrap/css/bootstrap-grid.min.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/bootstrap/css/bootstrap-reboot.min.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/fancybox/jquery.fancybox.min.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/amricons/css/amricons.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/pe-icon/css/pe-icon-7-stroke.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/slick/slick.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/slick/slick-style.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/css/animate.min.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/parsley/parsley.css')}}" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/css/style.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/css/amr-style.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/css/website-colors.css')}}" media="all" />'+
                    '<link rel="stylesheet" href="{{url('public/assets/web/css/dropzone.min.css')}}" media="all" />'+
                    '</head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 10);
        });

        $('#btn_cancel_order').click(function() {

            var base_url = "{{url('cancel_order')}}";
            var orderid = "{{$orders[0]->order_id}}";
            if (confirm("Do you want to cancel this order?")) {
                window.location.href=base_url+'/'+orderid;
            }else{
                return false;
            }
        });
    </script>
@endsection