@extends('layouts.web')

@section('content')

   
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="ps-breadcrumb__list">
                    <li class="active"><a href="{{url('/')}}">Home</a></li>
                    <li><a href="javascript:void(0);">{{$brands->title}}</a></li>
                </ul>
            </div>
        </div>
        <section class="section-shop shop-categories--default">
            <div class="container">
                <div class="row">
                    
                    <div class="col-12 col-lg-12">
                        <div class="category__top">
                            <div class="category__header">
                                <h3 class="category__name">
								<img src="{{ $brands->banner}}" class="top_cat_img">
								{{$brands->title}}
								</h3>
                              
                            </div>
                        </div>
                        <div class="result__header">
                            <h4 class="title"> {{count($product)}} <span>Product Found</span></h4>
                        </div>

                        <div class="result__header mobile">
                            <h4 class="title">   {{count($product)}}<span>Product Found</span></h4>
                        </div>
						
                        <div class="result__content mt-4">
                            	<div class="categories__products">
                                <div class="row m-0 get_brand_product">
 
                                        
									
									
							   </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
       
 
<script type="text/javascript">
     $.ajax({
            url:"{{route('get_brand_product')}}",
		    data:{id:<?php echo $brands->id; ?>,_token: '{{csrf_token()}}'},
			method:"post",  
           cache:false,
          success:function(response){
             console.log(response);
              $('.get_brand_product').html(response);
          }
     });
</script>

@endsection

