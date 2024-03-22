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
                <form action="{{url('purchases')}}" method="get">
                    <div class="row justify-content-end">
                        <div class="col-md-8 position-relative">
                            <button type="button" class="reset_button">&times;</button>
                            <input type="text" name="search_orders" value="{{isset($_REQUEST['search_orders']) ? $_REQUEST['search_orders'] : ''}}" placeholder="Search your orders" class="form-control input-lg text-black"/>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-blue">Search</button>
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
            @include('common.alerts')
            <div id="accordion">
                @foreach($orders as $purchases)
                    <?php
                    if(strpos($purchases->image, '//') !== false){
                        $urlex = explode(',', $purchases->image);
                        $url = $urlex[0];
                    }
                    else{
                        $url = url('public/'.$purchases->image);
                    }
                    ?>
                    <div class="card p-3 mb-4 border-0">
                        <div class="card-header mb-4 border-bottom-0" style="-webkit-box-shadow: 1px 5px 1px 1px rgba(194,194,194,0.37);
-moz-box-shadow: 1px 5px 1px 1px rgba(194,194,194,0.37);
box-shadow: 1px 5px 1px 1px rgba(194,194,194,0.37);border-radius: 0">
                            <div class="row align-items-center">
                                <div class="col-md-8 text-end">
                                    <img src="{{$url}}" style="width:50px;">
                                </div>
                                <div class="col-md-3 text-end">
                                    <button class="fw-bold btn btn-blue-outline" style="padding:10px 30px;font-size:14px;" data-bs-toggle="collapse" data-bs-target="#tab{{$purchases->id}}" aria-expanded="true" aria-controls="collapse{{$purchases->id}}">
                                        Undo Hide
                                    </button>
                                </div>
                                <div class="col-md-1 text-center">
                                    <button style="background-color:transparent;color:#3469EA;padding:0;font-size:30px;" data-bs-toggle="collapse" data-bs-target="#tab{{$purchases->id}}" aria-expanded="true" aria-controls="collapse{{$purchases->id}}">
                                        <i class="fa fa-close" style="-webkit-text-stroke: 3px #f7f7f7;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="tab{{$purchases->id}}" class="collapse show" aria-labelledby="heading{{$purchases->id}}" data-parent="#accordion">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="background-image-purchase" style="background-image:url('{{$url}}')"></div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        @if($purchases->delivery_status == 'delivered')
                                        <div class="col-md-1 text-end">
                                            <i class="fa fa-check-circle mt-3" style="color:#008248;font-size:30px;"></i>
                                        </div>
                                        @endif
                                        <div class="col-md-5">
                                            @if($purchases->delivery_status == 'delivered')
                                                <h5 class="text-black mb-0">Delivered</h5>
                                            @endif
                                            <p class="text-black mb-0">Order Date: {{date('M d, Y', strtotime($purchases->created_at))}}</p>
                                            <p class="text-black mb-0">Order Total: <b class="text-black">US ${{number_format($purchases->order_total, 2)}}</b></p>
                                            <p class="text-black">Order Number: {{$purchases->order_id}}</p>

                                            @if($purchases->delivery_status == 'delivered')
                                                <p class="text-black mb-0 fw-bolder">Delivered on {{date('M d, Y', strtotime($purchases->modify_at))}}</p>
                                            @endif
                                            <p class="text-black mb-0">Returns accepted through {{date('M d', strtotime($purchases->modify_at))}}.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-0 text-green">Delivered on <b class="text-green">{{date('D M, Y', strtotime($purchases->modify_at))}}</b></p>
                                            <div class="stepper-wrapper mt-3">
                                                <div class="stepper-item {{(!empty($purchases->is_payment_done)) ? 'completed' : ''}}">
                                                    <div class="step-counter"><i class="fa fa-check text-white"></i></div>
                                                    <div class="step-name">Paid</div>
                                                    <p class="fw-normal text-black">{{date('M d', strtotime($purchases->modify_at))}}</p>
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
                                    </div>
                                    <div class="product_info mt-4 position-relative">
                                        <p class="text-decoration-underline text-black mb-0">{{$purchases->product_name}}</p>
                                        <p class="text-black">Quantity: {{$purchases->product_quantity}}</p>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="text-black fw-bolder">US ${{number_format($purchases->sale_price, 2)}}</p>

                                                <p class="text-muted">
                                                    Sold by: <a href="{{url('vendor/'.$purchases->vendorid)}}" class="text-blue text-decoration-underline">{{$purchases->name}}</a>
                                                </p>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="text-area-show" id="textarea{{$purchases->id}}" style="display:none;">
                                                    <label class="text-black">Note</label>
                                                    <textarea class="form-control text-black" name="notes"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-md-4 mb-2">
                                            <a href="{{url('order_details/'.base64_encode($purchases->order_id).'/'.base64_encode($purchases->productid))}}" class="form-control btn btn-blue-outline">View order details</a>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#feedback{{$purchases->id}}" class="form-control btn btn-blue">Leave feedback</a>
                                        </div>
                                        <div class="col-md-4 position-relative">
                                            <a href="#" class="form-control btn btn-blue-outline show-filters" data-target="more-actions{{$purchases->id}}">More actions <i class="fa fa-angle-down"></i></a>
                                            <div class="more-actions position-absolute p-3" style="background-color:#fff;display:none;z-index:99;" id="more-actions{{$purchases->id}}">
                                                <ul>
                                                    <li><a class="text-decoration-underline text-black" href="{{url('product/'.$purchases->productid)}}">Buy again</a></li>
                                                    <li><a class="text-black" href="{{url('chats/'.$purchases->order_id.'/'.$purchases->productid)}}">Contact seller</a></li>
                                                    <li><a class="text-black" data-bs-toggle="modal" data-bs-target="#report{{$purchases->id}}" href="#">Report a problem</a></li>
                                                    <li><a class="text-black" href="{{url('product/'.$purchases->productid)}}">Sell this item</a></li>
                                                    <li><a class="text-black open-note" data-target="#textarea{{$purchases->id}}" href="#">Add note</a></li>
                                                    <li><a data-bs-toggle="collapse" aria-expanded="true" aria-controls="tab{{$purchases->id}}" class="text-black" data-bs-target="#tab{{$purchases->id}}" href="#" >Hide order</a></li>
                                                </ul>
                                            </div>
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

                                    <div class="modal fade" id="report{{$purchases->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header border-bottom-0">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <form action="{{url('return_items')}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{$purchases->order_id}}">
                                                        <input type="hidden" name="vendor_id" value="{{$purchases->vendorid}}">
                                                        <input type="hidden" name="product_id" value="{{$purchases->productid}}">
                                                        @csrf

                                                        <div class="step-form" id="step1{{$purchases->id}}">

                                                            <h2 class="text-black fw-bold">Return item</h2>

                                                            <h4 class="text-black fw-bold mb-4">Why are you returning this item?</h4>

                                                            <?php
                                                                $return_types = Config::get('constants.return_types');
                                                            ?>
                                                            @foreach($return_types as $key => $types)
                                                                <label class="text-black w-100 mb-3"><input type="radio" class="return-type" name="return_type" value="{{$key}}"/> &nbsp;&nbsp;&nbsp;{{$types}}</label>
                                                            @endforeach

                                                            <button type="button" data-target="#step2{{$purchases->id}}" class="btn btn-blue mt-4 next-step" disabled style="color:#fff;border-radius: 30px;padding:10px 70px;">Next</button>
                                                        </div>

                                                        <div class="step-form" id="step2{{$purchases->id}}" style="display:none;">
                                                            <h2 class="text-black fw-bold">Request a partial refund</h2>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="text-black mb-3">Quantity</label><br>
                                                                    <input type="number" name="quantity" min="0" max="{{$purchases->product_quantity}}" value="0" style="width:50px;border-radius:10px;" class="text-black text-center"> <span class="text-black"> &nbsp;&nbsp;/ {{$purchases->product_quantity}}</span>
                                                                </div>
                                                                <div class="col-md-2 mt-auto text-center">
                                                                    <h6 class="text-black fst-italic">OR</h6>
                                                                </div>
                                                                <div class="col-md-6 text-center">
                                                                    <label class="text-black fst-italic mb-3">Refund Percentage Requested</label><br>
                                                                    <input type="text" name="percentage" placeholder="25%" style="width:50px;border-radius:10px;" class="text-black text-center">
                                                                </div>
                                                            </div>

                                                            <div class="add-details mt-4">
                                                                <h5 class="text-black mb-3">Add details</h5>
                                                                <p class="text-black">We're sorry that the item wasn't what you expected. Let us know how your item differed, that information will help us to best resolve your return.</p>

                                                                <textarea class="form-control mb-4" name="details_decription" style="background-color:#f7f7f7;" placeholder="Give us a little more info." rows="5"></textarea>

                                                                <h5>Add photos (<span class="count_images">0</span>/10)</h5>
                                                                <p class="text-black"><i style="color:#3565F3" class="fa fa-info-circle"></i> Please provide photos to this return</p>

                                                                <div class="gallery row">

                                                                </div>

                                                                <input type="file" name="refund_images[]" id="image-filestep2{{$purchases->id}}" onchange="checkFiles(this)" class="upload_images" multiple accept="image/x-png, image/jpeg" style="display : none;"/>
                                                                <label class="image-label" for="image-filestep2{{$purchases->id}}"><i class="fa fa-plus-circle" style="font-size:70px;"></i> </label>

                                                            </div>

                                                            <button type="submit" disabled class="btn btn-default fst-italic text-black mt-4" style="border-radius: 15px;background-color: #E3E3E3">confirm partial refund</button>&nbsp;&nbsp;
                                                            <button type="button" data-target="#step3{{$purchases->id}}" class="mt-4 btn btn-blue next-step" style="border-radius: 15px;">Request a Return Instead</button>
                                                        </div>

                                                        <div class="step-form" id="step3{{$purchases->id}}" style="display:none;">
                                                            <h2 class="text-black fw-bold">Return item</h2>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="text-black mb-3">Quantity</label><br>
                                                                    <input type="number" name="return_quantity" min="0" max="{{$purchases->product_quantity}}" value="0" style="width:50px;border-radius:10px;" class="text-black text-center"> <span class="text-black"> &nbsp;&nbsp;/ {{$purchases->product_quantity}}</span>
                                                                </div>
                                                            </div>

                                                            <div class="add-details mt-4">
                                                                <h5 class="text-black mb-3">Add details</h5>
                                                                <p class="text-black">We're sorry that the item wasn't what you expected. Let us know how your item differed, that information will help us to best resolve your return.</p>

                                                                <textarea class="form-control mb-4" name="return_details_decription" style="background-color:#f7f7f7;" placeholder="Give us a little more info." rows="5"></textarea>

                                                                <h5>Add photos (<span class="count_images">0</span>/10)</h5>
                                                                <p class="text-black"><i style="color:#3565F3" class="fa fa-info-circle"></i> Please provide photos to this return</p>

                                                                <div class="gallery row">

                                                                </div>

                                                                <input type="file" name="return_images[]" id="image-filestep3{{$purchases->id}}" onchange="checkFiles(this)" class="upload_images" multiple accept="image/x-png, image/jpeg" style="display : none;"/>
                                                                <label class="image-label" for="image-filestep3{{$purchases->id}}"><i class="fa fa-plus-circle" style="font-size:70px;"></i> </label>

                                                                <div class="mt-4">
                                                                    <button type="submit" class="btn btn-default text-black" disabled style="border-radius: 15px;background-color: #E3E3E3">Confirm return</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @php
            if(isset($_REQUEST['search_orders'])){
                echo $orders->appends(['search_orders' => $_REQUEST['search_orders']])->links();
            }
            else{
                echo $orders->links();
            }
            @endphp
        </div>
    </main>
</div>
    <script>
        $('.reset_button').click(function(){
            $('input[name="search_orders"]').val('');
        });

        $('.show-filters').click(function(e){
            e.preventDefault();
            var target = $(this).data('target');
            $('.all-filters').fadeOut();
            $('#'+target).fadeToggle();
        });

        $('.open-note').click(function(e){
            e.preventDefault();
            var target = $(this).data('target');
            $(target).fadeIn();
            $(this).parent().parent().parent().fadeOut();
        });

        $('.return-type').change(function(){
            $(this).parent().parent().find('button').removeAttr('disabled');
        });

        var imagesPreview = function(input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        var html = '<div class="col-md-3"><img src="'+event.target.result+'"></div>';
                        $($.parseHTML(html)).appendTo(placeToInsertImagePreview);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
            }

        };

        function checkFiles(files) {

            var file = files.files;
            var id = $(files).attr('id');

            if(file.length>10) {

                let list = new DataTransfer;
                for(let i=0; i<10; i++)
                    list.items.add(file[i])

                document.getElementById(id).files = list.files;
            }

            imagesPreview(files, $(files).parent().find('.gallery'));

            var numFiles = $(files)[0].files.length;
            $(files).parent().find('.count_images').html(numFiles);
        }

        /*$('.upload_images').change(function(){

            var files = $(this).files;
            var id = $(this).attr('id');
            if($(this)[0].files.length>10) {
                alert("length exceeded; files have been truncated");

                let list = new DataTransfer;
                for(let i=0; i<10; i++)
                    list.items.add(files[i])

                document.getElementById(id).files = list.files
            }
            var numFiles = $(this)[0].files.length;
            $(this).parent().find('.count_images').html(numFiles);
        });*/

        $('.next-step').click(function(){
            var target = $(this).data('target');
            $(this).parent().hide();
            $(target).fadeIn();
        });

        $('input[name="quantity"], input[name="percentage"]').keyup(function(){
            if($(this).val() === '' && $(this).val() === 0){
                $(this).parent().parent().parent().find('.btn-default').attr('disabled', 'disabled');
            }
            else{
                $(this).parent().parent().parent().find('.btn-default').removeAttr('disabled');
            }
        });

        $('input[name="return_quantity"]').keyup(function(){
            if($(this).val() === '' && $(this).val() === '0'){
                $(this).parent().parent().parent().find('.btn-default').attr('disabled', 'disabled');
            }
            else{
                $(this).parent().parent().parent().find('.btn-default').removeAttr('disabled');
            }
        });
    </script>
@endsection