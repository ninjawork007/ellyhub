@extends('seller.layouts.common')
@section('content')
    <div id="primary" class="content-area mt-4 container-fluid">
        <div class="bg-white p-4" style="-webkit-box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);
-moz-box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);
box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);">
            <main id="main" class="site-main container purchases">
                <div class="row justify-content-between">
                    <div class="col-lg-3 col-md-3">
                        <h2 class="text-black fst-italic">Order details</h2>
                    </div>
                </div>

                <div class="orders order_details row" id="print_div">
                    @foreach($orders as $purchases)
                        <div class="col-md-12">
                            <div class="border p-3 mb-3" style="border-radius: 10px;">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="mt-0 mb-2 text-black">Ship by Aug 16 at 11:59pm PDT</h4>
                                        <p class="mb-0 text-black" style="font-size:15px;">Make sure you ship your order within the handling time you specified in the listing.</p>
                                        <p class="mb-0 text-black" style="font-size:15px;">Estimated delivery date shown to buyer: <b class="text-black">Aug 18, 2023 - Aug 23, 2023</b></p>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="mb-2 btn btn-blue w-100 rounded-pill text-white" href="#">Purchase shipping label</a>
                                        <a class="btn btn-blue-outline w-100 rounded-pill" href="#">More actions &nbsp;&nbsp;<i class="fa fa-angle-down"></i> </a>
                                    </div>
                                </div>

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
                            </div>
                            <div class="border p-3" style="border-radius: 10px;">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <h4 class="text-black">Shipping</h4>

                                        <div class="text-black">
                                            <a href="#" class="text-silver copy_text">Ship to <i class="text-black fa fa-copy"></i></a>
                                            <p>{{$orders[0]->name}}<br>{{$orders[0]->street_address}}<br>
                                                {{$orders[0]->city}}, {{$orders[0]->zip}}<br>
                                                {{$orders[0]->country}}
                                            </p>

                                            <p class="text-silver mb-0">Phone</p>
                                            <p class="text-black mb-0">{{$orders[0]->phone}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <h4 class="text-black">&nbsp;</h4>
                                        <p class="mb-0 text-silver">Buyer selected shipping service</p>
                                        <p class="text-black">Economy shipping</p>
                                        <div class="tracking_info">
                                            <h6 class="text-silver">Tracking</h6>
                                            @if(!empty($purchases->tracking_id))
                                                <p class="text-black">
                                                    {{$purchases->tracking_id}}
                                                </p>
                                            @else
                                                <p class="text-black fw-bold">
                                                    ...
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-black">&nbsp;</h4>
                                        <a class="btn btn-blue-outline w-100 rounded-pill bg-transparent" href="#">Add tracking</a>
                                    </div>
                                </div>
                            </div>
                            <div class="border p-3 mt-4" style="border-radius: 10px;">
                                <div class="items-info mb-5">
                                    <h5 class="text-black">Item</h5>

                                    <div class="row">
                                        <div class="col-md-2">
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
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="text-black text-decoration-underline">{{Str::limit($purchases->product_name, 60, '')}}</h6>
                                                    <h6 class="text-black fw-bold">Custom label (SKU): {{$purchases->sku}}</h6>
                                                    <p class="text-muted mb-2" style="color:#7B7B7B;font-size:14px;"><b style="color:#7B7B7B;">Item ID: </b>{{$purchases->productid}}</p>
                                                    <a class="text-blue mb-0" style="font-size:14px;" href='#'>Add tracking</a>
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    <p class="text-silver">Quantity</p>
                                                    <p class="text-black">{{$purchases->product_quantity}}</p>
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    <p class="text-silver">Price</p>
                                                    <h6 class="text-black fw-bold">${{number_format($purchases->product_price, 2)}}</h6>
                                                </div>
                                                <div class="col-md-2 text-end">
                                                    <p class="text-silver">Total</p>
                                                    <h6 class="text-black fw-bold">${{number_format($purchases->after_discount_paid_by_customer, 2)}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="p-3 border rounded-4">
                                        <h4 class="text-black">Order</h4>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p class="text-muted">Order no.</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="text-black">{{$purchases->order_id}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p class="text-muted">Sales record no.</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="text-black">{{$purchases->id}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p class="text-muted">Date sold</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="text-black">{{date('M d, Y', strtotime($purchases->created_at))}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p class="text-muted">Date buyer paid</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="text-black">{{date('M d, Y', strtotime($purchases->payment_date))}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <p class="text-muted">Buyer </p>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="text-black">{{$purchases->name}}</span><br>
                                                <span class="text-decoration-underline text-black">{{$purchases->name}}</span> <span class="text-decoration-underline text-black">{{$purchases->userid}}</span>
                                            </div>
                                        </div>

                                        <a href="#" class="text-black text-decoration-underline">Show contact info <i class="ps-3 fa fa-angle-down text-decoration-none"></i> </a>
                                        <br>
                                        <div class="text-center">
                                            <a href="#" class="mt-3 w-75 bg-transparent text-blue btn btn-blue-outline rounded-pill">Contact buyer</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <div class="p-3 border rounded-4">
                                        <h4 class="text-black">Payment</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="text-muted" style="font-size:13px;">Fund status</p>
                                            </div>
                                            <div class="col-md-8 text-end">
                                                <p class="text-black mb-0" style="font-size:13px;"><span class="activity-circle processing"></span> &nbsp;Processing</p>
                                                <p class="text-black mb-0" style="font-size:13px;">Estimated Funds availability<br>on Aug 16, 2023</p>
                                            </div>
                                        </div>

                                        <div class="rounded-4 bg-silver p-3 mt-3">
                                            <h5 class="text-black mb-2">What your buyer paid</h5>

                                            <div class="p-3">
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <p class="text-black mb-0">item subtotal</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <p class="text-black mb-0">${{number_format($purchases->product_price, 2)}}</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <p class="text-black mb-0">Shipping</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <p class="text-black mb-0">$0.00</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <p class="text-black mb-0">Sales tax</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <p class="text-black mb-0">$0.00</p>
                                                    </div>
                                                </div>

                                                <div class="border-bottom" style="border-color:#000 !important;"></div>

                                                <div class="row mb-2 mt-2">
                                                    <div class="col-md-6">
                                                        <p class="text-black mb-0 fw-bold">Order total</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <p class="text-black mb-0 fw-bold">${{number_format($purchases->product_price, 2)}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="p-3 border rounded-4">

                                        <div class="rounded-4 bg-silver p-3">
                                            <h5 class="text-black mb-2">What your earned</h5>

                                            <div class="p-3">
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <p class="text-black mb-0">Order total</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <p class="text-black mb-0">${{number_format($purchases->after_discount_paid_by_customer, 2)}}</p>
                                                    </div>
                                                </div>
                                                <p class="text-black mb-2 mb-0" style="font-size:14px;">Ellyhub collected from buyer</p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="text-black mb-0 ps-3">Sales tax</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <p class="text-black mb-0">$0.00</p>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-8">
                                                        <p class="text-black mb-0" style="font-size:14px;">Selling costs</p>
                                                        <p class="text-black mb-0 ms-3" style="width:fit-content;border-bottom:1px dashed #000;">Transaction fees</p>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        <p class="text-black mb-0">&nbsp;</p>
                                                        <p class="text-black mb-0">$0.00</p>
                                                    </div>
                                                </div>

                                                <div class="border-bottom" style="border-color:#000 !important;"></div>

                                                <div class="row mt-3">
                                                    <div class="col-md-7">
                                                        <p class="text-black mb-0 fw-bold" style="width:fit-content;border-bottom:1px dashed #000;">Order earnings</p>
                                                    </div>
                                                    <div class="col-md-5 text-end">
                                                        <p class="text-black mb-0 fw-bold">${{number_format($purchases->after_discount_paid_by_customer, 2)}}</p>
                                                    </div>
                                                </div>

                                                <div class="mt-3">
                                                    <a href="#" class="text-black mt-3" style="border-bottom:1px solid #000;">See more details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 col-md-12 p-4 bg-silver">
                            <h3 class="ps-5 mb-5 text-black">Product Timeline</h3>

                            <h4 class="ms-5 mt-3 border-top border-bottom py-3 text-black">Today</h4>

                            <ul class="product_history ps-3">
                                <li>
                                    <div class="first">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-black fw-bold mb-0">Item sold</p>
                                                <p class="text-black">by <a class="text-blue" href="#">{{$purchases->vendor_name}}</a></p>
                                                <p class="text-black">Item sold. Shipping address: {{$orders[0]->street_address}}
                                                    {{$orders[0]->city}}, {{$orders[0]->zip}}
                                                    {{$orders[0]->country}}</p>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <p class="mb-0 text-silver"><i class="fa fa-clock-o"></i> 9:44pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="first">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-black fw-bold mb-0">Recieved message</p>
                                                <p class="text-black">by <a class="text-blue" href="#">{{$purchases->user_name}}</a></p>
                                                <p class="mb-0 text-black">You recieved message</p>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <p class="mb-0 text-silver"><i class="fa fa-clock-o"></i> 8:37pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="first">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-black fw-bold mb-0">Product price changed</p>
                                                <p class="text-black mb-0">by <a class="text-blue" href="#">You</a></p>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <p class="mb-0 text-silver"><i class="fa fa-clock-o"></i> 9:07pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <h4 class="ms-5 mt-3 border-top border-bottom py-3 text-black">20 May, 2023</h4>

                            <ul class="product_history product_history_first ps-3">
                                <li>
                                    <div class="first">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-black fw-bold mb-0">Product Published</p>
                                                <p class="text-black mb-0">by <a class="text-blue" href="#">You</a></p>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <p class="mb-0 text-silver"><i class="fa fa-clock-o"></i> 9:07pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="first">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <p class="text-black fw-bold mb-0">Product Drafted</p>
                                                <p class="text-black mb-0">by <a class="text-blue" href="#">You</a></p>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <p class="mb-0 text-silver"><i class="fa fa-clock-o"></i> 9:07pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
@endsection
@section('script')
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