@extends('layouts.web')
@section('pagebodyclass')
full-width white-bg @endsection
@section('content')
<style type="text/css">
    @media print {
    .myDivToPrint {
        background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;
    }
    #primary{
        height: 100%;
        width: 100%;
    }
}
</style>



<style>
    @media (max-width:900px){
 table.table.table-bordered.table-package.js-scrollable.scroll-hint.is-scrollable {
    display: block;
    white-space: nowrap;
    width: 100%;
}   
        }
</style>
<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Order Detail
</nav>

<div id="primary" class="content-area">
    @include('alerts')
    @if($orders[0]->order_status=='cancelled')
    <div class="alert alert-info" role="alert">
      Order Cancelled.
    </div>
    @endif
    @if(isset($_GET['search']))
    <div class="alert alert-info" role="alert">
      Order Status:- {{$orders[0]->delivery_status}}
    </div>
    @endif
    <main id="main" class="site-main" style="margin-top: 40px;">
        <div class="container">
            <div id="print_div" class="card "style="padding: 15px 15px;">
                <div class="card-head">
                	<div class="row">
                		<div class="col-md-6">
                			<img src="{{url('public/'.$setting[0]->logo)}}" style="width: 160px;margin-left: 14%;">
                		</div>
                		<div class="col-md-6">
                			<p style="text-align: right;">Tax invoice/Bill of supply/Cash memo</p>
                		</div>
                	</div>
                    <div class="row">
			
                    <div class="col-md-6" style=" padding: 1% 8%;">
			<h3 style= "color:#000;font-size: 18px;line-height: 1.5;">Bill To:</h3>
                         <p class="mb-1"> Name : {{$orders[0]->name}}</p>
                         <p class="mb-1">{{$orders[0]->street_address}}, {{$orders[0]->city}}, {{$orders[0]->country}}, {{$orders[0]->zip}}</p>
                        <p class="mb-1">Phone:{{$orders[0]->phone}}</p>
                        <p class="mb-1">Email:{{$orders[0]->email}}</p>
                       
                    </div>
					<div class="col-md-6" style="padding: 1% 8%;">
			            <h3 style= "color:#000;font-size: 18px;line-height: 1.5;">Order Id :{{$orders[0]->order_id}}</h3>
                        <p><b>Invoice date:- </b>{{date('d/m/Y',strtotime($orders[0]->created_at))}}</p>
                        @if($orders[0]->tracking_id)
                        <p><b>Tracking ID:- </b>{{$orders[0]->tracking_id}}</p>
                        @endif
                    </div>
             
                </div>
                </div>
         
                <div class="card-body">
                    <div class="order-1d">
                    </div>
                    <!-- loop row -->
                 
                    <div class="row">
                        <div class="col">
                           
                                <div class="card-body ">
                               <table class="table table-bordered table-package js-scrollable scroll-hint is-scrollable" style="position: relative;overflow: auto;width: 100%;">
							  <thead>
							    <tr>
							      <th style="padding: 2px !important;text-align: center;font-size: 14px;">Item</th>
							      <th style="padding: 2px !important;text-align: center;font-size: 14px;">Sold By</th>
							      <!-- <th style="padding: 2px !important;text-align: center;font-size: 14px;">MRP</th> -->
							      <th style="padding: 2px !important;text-align: center;font-size: 14px;">Price Per Unit</th>
							      <th style="padding: 2px !important;text-align: center;font-size: 14px;">Quantity</th>
								    <th style="padding: 2px !important;text-align: center;font-size: 14px;">Total Price</th>
							    </tr>
							  </thead>
								<tbody>
								@if(count($orders))
								@foreach($orders as $key)
									<tr>
										<td style="padding: 2px !important;text-align: center;font-size: 14px;">{{$key->product_name}}</td>
										<td style="padding: 2px !important;text-align: center;font-size: 14px;">{{$key->vendoe_name}}</td>
										<td style="padding: 2px !important;text-align: center;font-size: 14px;">{{$setting[0]->currency_sign}}{{$key->sale_price}}</td>
										<td style="padding: 2px !important;text-align: center;font-size: 14px;">{{$key->product_quantity}}</td>
										<td style="padding: 2px !important;text-align: center;font-size: 14px;">{{$setting[0]->currency_sign}}{{$key->total_price}}</td>
									</tr>
								@endforeach @endif
								</tbody>
</table>
                             
                                </div>
                        
                        </div>
                    </div>
                    
                    
                   <br>
                    
                    
                </div>
                <div class="footer "style="padding: 10px;">
                    <div class="row">
                    <div class="col-md-12" style=" border: 1px solid #eceeef;padding: 10px;">
                      <p class="mb-0 "style="text-align: right; font-size: 16px;"> Shipping Charges:- {{$delivery}}</p>
                      <p class="mb-0 "style="text-align: right; font-size: 16px;"> Total Bill:- {{$orders[0]->order_total}}</p>
   
  
 
      <td colspan="9"> <h2 class="mb-0 "style="text-align: right;
          font-size: 22px;">Authorized signature</h2> </td>

                        
                            </div>
                          
                    </div>
                </div>
            </div>
            @if(!isset($_GET['search']))
              <div class="print" style="text-align: center; padding: 13px 0 0 0;">
		            <button class="button" id="btn_print" style="background: #030d4a;padding: 14px 50px;font-size: 20px;">Print</button>
                    @if($orders[0]->delivery_status!=='delivered')
                        @if($orders[0]->order_status!=='cancelled')
                        <button class="button" id="btn_cancel_order" style="background: #e68305;padding: 14px 50px;font-size: 20px;" >Cancel Order</button>
                        <a href="{{url('rate-and-review/'.$orders[0]->order_id)}}" class="button" id="rate_products" style="background: #e68305;padding: 14px 50px;font-size: 20px;" >Rate Product</a>
                        @endif
                    @endif
		        </div> 
            @endif
        </div>
    </main>
</div>

<script type="text/javascript">
$("#btn_print").click(function() {
    var divToPrint = document.getElementById('print_div');
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><head><link rel="stylesheet" href="//bazarhat99.com/public/assets/web/bootstrap/css/bootstrap.min.css"></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
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