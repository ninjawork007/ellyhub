@extends('layouts.web')
@section('pagebodyclass')
full-width
@endsection
@section('content')
    
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Track Order
</nav>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin">
                        <div class="card-body registration__info">
                            <h5 class="card-title text-center"></h5>
                            
                            <div class="error_"></div>
                           
                            <form method="post" action="" data-parsley-validate="" id="track_order">
                                @csrf
                                <div class="form-label-group  mb-3">
                                    <input class="form-control" type="text" placeholder="Order id" id="orderid" required="" data-parsley-trigger="change">
                                </div>
                                <button class="btn ps-button btn-lg btn-primary btn-block text-uppercase  mb-3" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script type="text/javascript">
$('#track_order').on('submit', function(e) {
    e.preventDefault();
    
    var orderid = $('#orderid').val();
    var base64_orderid = "<?php echo base64_encode("+orderid+"); ?>";
    base_url = "{{url('/')}}";
    window.location.href=base_url+"/order_detail/"+orderid+"?search=true";
});
</script>

@endsection