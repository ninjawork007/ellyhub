@extends('layouts/master')
@section('content')
 <!-- Slider Area Start-->  
  <!-- breadcumb Start-->
        <div class="breadcumb-area text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 p-0">
						<div class="breadcumb-img">
								<img src="{{ asset('public/assets/images/breadcumb.jpg') }}" alt="about thumb">
							</div>
						<div class="breadcumb-list">
                            <ul class="list-inline">
                               <li class="list-inline-item"><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right" aria-hidden="true"></i></li>
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
            </div>
  <!-- breadcumb End-->
  <section class="dashboard-counts section-padding">
      <div class="container">
  <div class="content-box">
      <div class="row">
         <div class="col-md-7 m-auto">
			       <div class="card-body">   
              
            @if (session('error') || session('success'))
             <p class="{{ session('error') ? 'error':'success' }}">
              {{ session('error') ?? session('success') }}
             </p>
             
          @endif
         <div class="box-loading">
    <div class="display-loading open"></div>
    <div>Loading...</div>
</div> 
            <?php $total = 0;
            $OrderItems = session()->get('cart');
                  foreach ($OrderItems as $item){
                   
                      $item_price =  $item['price'];
                      $item_title =  $item['title'];
                      $item_quenty = $item['qty'];
                      $product_price =$item_price*$item_quenty;
                       $total += $product_price;
                  }
              
             ?>
             <form method="POST" action="{{ route('create-payment') }}" name="form_trans" id="form_trans">
              
          @csrf
              <div class="m-2">
			  <?php if (session()->get('alltotal')) {				
									$total = session()->get('alltotal');
								} else {
									$total;
								}?>
               <input type="hidden" name="amount"  value="<?php echo $total; ?>">
               <input type="hidden" name="product_title" value="<?php echo $item_title; ?>">
               <input type="hidden" name="currency"  value="GBP">
               <input type="hidden" name="qty"  value="<?php echo $item_quenty; ?>">
               <input type="hidden" name="order_id"  value=<?php echo $lastId; ?>>
			   <input type="hidden" name="business" value="mandyweb.business@gmail.com">
               
          @if ($errors->has('amount'))
               <span class="error"> {{ $errors->first('amount') }} </span>
               
          @endif
              </div>
              
             </form>
             <script>document.form_trans.submit();</script>
            
              </div>
          </div>
      </div>
  </div>                 
  </div>  
</section>  
@endsection
