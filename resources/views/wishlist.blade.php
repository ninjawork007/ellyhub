@extends('layouts.web')



@section('content')



      <nav class="amrcart-breadcrumb">
    <a href="https://bazarhat99.com">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Wishlist
</nav>

         <div id="primary" class="content-area">
<main id="main" class="site-main">

            <div class="container">

                <h2 class="page__title">Wishlist</h2>

                <div class="wishlist__content">

                    <div class="wishlist__product">

                        <div class="wishlist__product--desktop">

                            @if(count($wishlist))

                            <table class="shop_table shop_table_responsive cart">

                                <thead>

                                    <tr>

                                        <th scope="col">Product</th>

                                        <th scope="col">Price</th>

                                        <th scope="col">Date</th>

                                        <th scope="col">Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($wishlist as $key)

                                    <tr id="{{$key->id}}">

                                        <td data-title="Product" class="product-name">

                                            <a href="{{url('/product/'.$key->product_id)}}">

                                                <img src="{{url($key->image)}}" style="max-width: 100px;">

                                                {{$key->name}}

                                            </a>

                                        </td>

                                        <td data-title="Price" class="product-price">₹{{$key->sale_price}}</td>

                                        <td data-title="Date" class="product-price">{{date('d F, Y',strtotime($key->created_at))}}</td>

                                        <td data-title="Remove" class="product-price"><div class="wishlist__trash wishlist" data-id="{{$key->id}}"><a title="Remove this item icon-trash2 wishlist" class="remove" 
                                    href="#">×</a></div></td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            @else

                            <div class="text-center">

                                <img src="{{url('/not-found.jpg')}}">

                                <p>No Wishlist Found.</p>

                            </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>
</main>
        </div>



<script type="text/javascript">

    $('.wishlist__trash.wishlist').click(function(){

        id = $(this).attr('data-id');

        if (confirm('Do you want to remove from wishlist?')) {

            $.ajax({

            url:'/remove_from_wishlist',

            data:{id:id},

            cache:false,

            success:function(res){

              if (res) {

                window.location.reload();

                // /$('#cartrow'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});

              }

            }

          }); 

        }else{

            return false;

        }

    });

</script>

@endsection



