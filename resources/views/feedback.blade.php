@extends('layouts.web')
@section('pagebodyclass')
full-width @endsection
@section('content')
<div id="primary" class="content-area">
    <main id="main" class="site-main container-fluid feedback">
        <div class="alert alert-danger alert-dismissible" style="display:none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h6><i class="icon fa fa-ban"></i> Error: {{ Session::get('danger') }}</h6>
        </div>
        <div class="alert alert-success alert-dismissible" style="display:none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h6><i class="icon fa fa-check"></i> Success: {{ Session::get('success') }}</h6>
        </div>
        <div class="alert alert-warning alert-dismissible" style="display:none;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h6><i class="icon fa fa-warning"></i> Warning: {{ Session::get('warning') }}</h6>
        </div>
            @if($type== 'happy')
                <h3 class="text-black">Leave feedback</h3>

                <div class="border p-3">
                    <div class="row">
                        <div class="col-md-2">
                            <?php
                            if(strpos('http', $order[0]->image) !== false){
                                $url = $order[0]->image;
                            }
                            else{
                                $url = url('public/'.$order[0]->image);
                            }
                            ?>
                            <img src="{{$url}}" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <p class="text-black">{{$order[0]->product_name}}</p>
                            <p class="text-muted">
                                Sold by: <a href="#" class="text-black">{{$order[0]->name}}</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-black" style="line-height:2;">Great to hear your purchase was successful!<br>
                                We'd love to hear more about your experience</h4>
                        </div>
                    </div>
                    <form class="border-0" action="{{url('submit_feedback')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="type" value="{{$type}}">
                        <input type="hidden" name="order_id" value="{{$order_id}}">
                        <input type="hidden" name="type" value="{{$type}}">
                        <input type="hidden" name="vendor_id" value="{{$order[0]->vendorid}}">
                        <input type="hidden" name="product_id" value="{{$order[0]->productid}}">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="text-black" style="line-height:2;">Please share additional feedback to<br>
                                    help us continue providing excellent<br>service.<br>
                                </h5>
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control pt-3" name="description" maxlength="500" id="word_count" style="background-color:#F7F7F7" rows="4" placeholder="Share your feedback here."></textarea>
                                <p class="text-black text-end pt-1"><span class="count_textarea">0</span> / 500</p>
                            </div>
                        </div>

                        <div class="photos-section">
                            <h4 class="text-black">Add up to 5 photos</h4>
                            <div class="row">
                                <div class="col-md-5">
                                    <p class="text-muted" style="font-size:14px;">
                                        We'll start displaying item photos with your feedback soon. Make<br>
                                        sure you follow our <a href="#" class="text-black text-decoration-underline">Images, Videos, and Text Policy</a>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="text-black fst-italic"><span class="images-upload">0</span> of 5</p>
                                    <input type="file" name="file[]" id="image-filestep3" onchange="checkFiles(this)" class="upload_images" multiple accept="image/x-png, image/jpeg" style="display : none;"/>
                                    <label class="image-label" for="image-filestep3"><i class="fa fa-plus-circle" style="font-size:70px;"></i> </label>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="submit_feedback" class="btn btn-blue">Cancel Feedback</button>
                                </div>
                            </div>

                            <div class="gallery row">

                            </div>
                        </div>
                    </form>
                </div>
                @else
                <h4 class="text-black">Okay, Let's resolve this issue:</h4>

                <div class="border p-3">
                    <div class="row">
                        <div class="col-md-2">
                            <?php
                            if(strpos($order[0]->image, '//') !== false){
                                $urlex = explode(',', $order[0]->image);
                                $url = $urlex[0];
                            }
                            else{
                                $url = url('public/'.$order[0]->image);
                            }
                            ?>
                            <img src="{{$url}}" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <p class="text-black">{{$order[0]->product_name}}</p>
                            <p class="text-muted">
                                Sold by: <a href="#" class="text-black">{{$order[0]->name}}</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-black" style="line-height:2;">We're sorry to hear about the unresolved issue you encountered.<br>
                            Your input is essential in finding a resolution.</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-black text-center">&nbsp;</p>
                            <div class="border p-3 text-center mb-4">
                                <form id="refund" class="text-center" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$order_id}}">
                                    <input type="hidden" name="vendor_id" value="{{$order[0]->vendorid}}">
                                    <input type="hidden" name="product_id" value="{{$order[0]->productid}}">

                                    <div class="row justify-content-center my-4">
                                        <div class="col-md-5 text-center">
                                            <p class="text-black">Partial Refund</p>

                                            <div class="col-md-5 mx-auto">
                                                <input type="text" name="refund_price" class="form-control text-center" placeholder="$0.00">
                                            </div>

                                            <p class="my-3 text-black">or</p>

                                            <div class="col-md-5 mx-auto">
                                                <input type="text" name="refund_percentage" class="form-control text-center" placeholder="0.00%">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-4 text-center"><p class="text-black">or</p></div>
                                        <div class="col-md-5 text-center position-relative">
                                            <p class="text-black">Request full refund<br>with return</p>

                                            <div class="onoffswitch alertChanges">
                                                <input type="checkbox" name="refund" value="full" class="onoffswitch-checkbox" id="myonoffswitch2">
                                                <label class="onoffswitch-label" for="myonoffswitch2">
                                                    <span class="onoffswitch-inner" data-value=""></span>
                                                    <span class="onoffswitch-switch" data-value=""></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="message_refund" style="display:none;">
                                        <div class="alert">
                                            <p>Your request has been<br>submitted to the seller</p>
                                        </div>
                                    </div>
                                    <button type="submit" id="refund_btn" name="submit" class="btn btn-primary">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p class="text-decoration-underline text-black text-center">Report issue with a user</p>
                            <div class="border p-3 text-center mb-4" style="border-radius: 30px;">
                                <form id="report_user" class="text-center" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$order_id}}">
                                    <input type="hidden" name="vendor_id" value="{{$order[0]->vendorid}}">

                                    <div class="form-check mb-3">
                                        <label class="text-black"><input type="checkbox" name="policies[]" value="User is being abusive"/> User is beign abusive</label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <label class="text-black"><input type="checkbox" name="policies[]" value="User violated Ellyhub Policies"/> User violated Ellyhub Policies</label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <label class="text-black"><input type="checkbox" name="policies[]" value="Other"/> Other</label>
                                    </div>

                                    <div class="description mb-4 text-start col-md-10 mx-auto">
                                        <label class="text-decoration-underline text-black mb-2">Description</label>
                                        <textarea name="report_description" id="report_description" maxlength="300" class="form-control" rows="5"></textarea>
                                        <p class="text-black text-end"><span class="report_count">0</span> / 300</p>
                                    </div>

                                    <div class="message_report" style="display:none;">
                                        <div class="alert">

                                        </div>
                                    </div>
                                    <button type="submit" id="report_btn" name="submit" class="btn btn-primary btn-sm">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p class="text-decoration-underline text-black text-center">Resolution Center Messaging:</p>
                            <div class="border p-3 text-center mb-4" style="border-radius: 15px;">
                                <div class="text-start">
                                    <p class="text-black mb-0"><b class="text-black">Buyer: </b>Comment</p>
                                    <small class="text-black mb-0">{{date('m/d/y h:iA')}}</small>
                                </div>
                                <div class="text-end">
                                    <p class="text-black mb-0"><b class="text-black">Seller: </b>Comment</p>
                                    <small class="text-black mb-0">{{date('m/d/y h:iA')}}</small>
                                </div>
                                <div class="text-start">
                                    <p class="text-black mb-0"><b class="text-black">Buyer: </b>Comment</p>
                                    <small class="text-black mb-0">{{date('m/d/y h:iA')}}</small>
                                </div>
                                <div class="text-end">
                                    <p class="text-black mb-0"><b class="text-black">Seller: </b>Comment</p>
                                    <small class="text-black mb-0">{{date('m/d/y h:iA')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{url('submit_feedback')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="type" value="{{$type}}">
                        <input type="hidden" name="order_id" value="{{$order_id}}">
                        <input type="hidden" name="type" value="{{$type}}">
                        <input type="hidden" name="vendor_id" value="{{$order[0]->vendorid}}">
                        <input type="hidden" name="product_id" value="{{$order[0]->productid}}">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="text-black" style="line-height:1.5;">Leave your final feedback:<br>
                                    Describe why the user was not able to<br>
                                    work out your issue.<br>
                                    This feedback will remain on the user's<br>profile unless
                                    the conflict is eventually <br>resolved.
                                </h5>
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control pt-3" name="description" maxlength="500" id="word_count" style="background-color:#F7F7F7" rows="7" placeholder="Share your feedback here."></textarea>
                                <p class="text-black text-end pt-1"><span class="count_textarea">0</span> / 500</p>
                            </div>
                        </div>

                        <div class="photos-section">
                            <h4 class="text-black">Add up to 5 photos</h4>
                            <div class="row">
                                <div class="col-md-5">
                                    <p class="text-muted" style="font-size:14px;">
                                        We'll start displaying item photos with your feedback soon. Make<br>
                                        sure you follow our <a href="#" class="text-black text-decoration-underline">Images, Videos, and Text Policy</a>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="text-black fst-italic"><span class="images-upload">0</span> of 5</p>
                                    <input type="file" name="file[]" id="image-filestep3" onchange="checkFiles(this)" class="upload_images" multiple accept="image/x-png, image/jpeg" style="display : none;"/>
                                    <label class="image-label" for="image-filestep3"><i class="fa fa-plus-circle" style="font-size:70px;"></i> </label>
                                </div>
                                <div class="col-md-4">
                                    <button href="{{url('/')}}" name="submit_feedback" class="btn btn-dark-blue mb-3">Submit Resolution Request</button>
                                    <a href="{{url('/')}}" name="submit_feedback" class="btn btn-blue">Cancel Resolution Request</a>
                                </div>
                            </div>

                            <div class="gallery row">

                            </div>
                        </div>
                    </form>
                </div>
            @endif
    </main>
</div>
<script>

    $(document).ready(function() {
        $('#word_count').keyup(function () {
            var max_length = $(this).attr('maxLength');
            var len = $(this).val().length;
            if(len > max_length){

            }
            else{
                $('.count_textarea').text(len);
            }
        });

        $('#report_description').keyup(function () {
            var max_length = $(this).attr('maxLength');
            var len = $(this).val().length;
            if(len > max_length){

            }
            else{
                $('.report_count').text(len);
            }
        });
    });

    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var html = '<div class="col-md-2"><img src="'+event.target.result+'"></div>';
                    $($.parseHTML(html)).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    function checkFiles(files) {

        var file = files.files;
        var id = $(files).attr('id');

        if(file.length>5) {

            let list = new DataTransfer;
            for(let i=0; i<5; i++)
                list.items.add(file[i])

            document.getElementById(id).files = list.files;
        }

        imagesPreview(files, $('.gallery'));

        var numFiles = $(files)[0].files.length;
        $('.images-upload').html(numFiles);
    }

    $('#refund').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'{{url('refund_value')}}',
            method: "post",
            data : $('#refund').serialize(),
            beforeSend: function(){
                $('#refund_btn').html('Please wait..');
                $('#refund_btn').prop('disabled', true);
            },
            success: function(response){
                $('#refund_btn').html('SUBMIT');
                $('#refund_btn').prop('disabled', false);

                $('.message_refund').show();
                if(response.type === 'error'){
                    $('.message_refund').find('.alert').addClass('alert-danger');
                    $('.message_refund').find('.alert').empty().append(response.message);
                }

                if(response.type === 'success'){
                    $('.message_refund').find('.alert').addClass('alert-success');
                    $('.message_refund').find('.alert').empty().append(response.message);
                }

            }
        });
    });

    $('#report_user').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'{{url('report_users')}}',
            method: "post",
            data : $('#report_user').serialize(),
            beforeSend: function(){
                $('#report_btn').html('Please wait..');
                $('#report_btn').prop('disabled', true);
            },
            success: function(response){
                $('#report_btn').html('SUBMIT');
                $('#report_btn').prop('disabled', false);

                $('.message_report').show();
                if(response.type === 'error'){
                    $('.message_report').find('.alert').addClass('alert-danger');
                    $('.message_report').find('.alert').empty().append(response.message);
                }

                if(response.type === 'success'){
                    $('.message_report').find('.alert').addClass('alert-success');
                    $('.message_report').find('.alert').empty().append(response.message);
                }

            }
        });
    });
</script>
@endsection