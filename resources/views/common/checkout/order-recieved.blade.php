@extends('layouts/master')
@section('title')
Order Received
@endsection
@section('content')
 <!-- Slider Area Start-->  
  <!-- breadcumb Start-->
        <div class="breadcumb-area text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-inline">
                               <li class="list-inline-item"><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
                                @for($i = 0; $i <= count(Request::segments()); $i++)
                                <li class="list-inline-item">
                                  <a href="">{{Request::segment($i)}}</a>
                                  @if($i < count(Request::segments()) & $i > 0)
                                    {!!'<i class="fa fa-angle-right"></i>'!!}
                                  @endif
                                  </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
  <!-- breadcumb End-->
  <section class="dashboard-counts section-padding">
      <div class="container">
  <div class="content-box">
      <div class="row">
         <div class="col-md-7 m-auto">
			<div class="card-body">   
          @if(Session::get('cart'))
         <div class="mainHeading text-uppercase text-center mb-3"> Thank you for your order ! :)</div><br>
         <p class="text-center">Thank you.Your order has been received</p>
			<!---div class="col-md-6 m-auto">	
			<ul class="list-group">
			  <li class="list-group-item d-flex justify-content-between align-items-center">
				Order number -
				<span class="badge badge-pill">14</span>
			  </li>
			  <li class="list-group-item d-flex justify-content-between align-items-center">
				Date - 
				<span class="badge badge-pill">19-06-2019</span>
			  </li>
			  <li class="list-group-item d-flex justify-content-between align-items-center">
				Payment Method - 
				<span class="badge badge-pill">Debit Card</span>
			  </li>
			</ul>	
			</div---->
			<br>
			<div class="custom-title text-center">
             <h2> Order Details</h2>
            </div>
		<div class="col-md-9 m-auto">	
		  <div class="order-details mb--30">
          <table id="checkout" class="table table-hover table-condensed order-table">
              <thead>
                <tr>
                  <th>Product</th>
                   <th>Total</th>
                </tr>
              </thead>
              @php $total = 0; @endphp
              @foreach (session::get('cart') as $item)
              <tbody>
                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="nomargin">@php echo $item['title']; @endphp, *@php echo $item['qty']; @endphp</h4>
								@if($item['variation'] != ' ')
														<ul class="nav flex-column">
														<li class="nav-item">Variations - 
														@foreach($item['variation'] as $key => $variate)
														<span class="cart_option">{{$key }} - {{ $variate }}</span>
														@endforeach</li>
														</ul>
													@endif
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">
                      @php $item_price =  $item['price'];
                      $item_quenty = $item['qty'];
                      $product_price =$item_price*$item_quenty;
                      @endphp 
                     £@php  echo $product_price;
                      @endphp 
                  </td>
                </tr>
              </tbody>
              @php $total += $product_price; @endphp
              @endforeach
              <thead class="total-price">
                <tr>
                  <td>Total</td>
                  <td>
                   
                                 
				 <?php if (session()->get('alltotal')) {
					  echo '<input type="hidden" name="total_price" value="'.number_format(session()->get('alltotal'),2).'">';
						echo '£' . number_format(session()->get('alltotal'),2);
					
					} else {
						echo '<input type="hidden" name="total_price" value="'.number_format($total,2).'">';
						echo '£' . number_format($total,2);
					}?>
					 </td>
                </tr>
              </thead>
             
          </table>
            @else
                <h3>You have no permission</h3>
            @endif
            @php 
              //cart session unset
                  $cart = session()->get('cart');
                  session()->forget('cart');
            @endphp
              </div>
              </div>
              </div>
              </div>
              </div>
  </div>                 
  </div>  
</section>  
@endsection
