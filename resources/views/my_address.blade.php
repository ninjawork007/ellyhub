@extends('layouts.web')



@section('content')

<nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Address
</nav>

<div class="my-address">
    <div  class="content-area">
<main id="main" class="site-main">

            <div class="container">

      

                <h2 class="page__title">Address</h2>

                <div class="wishlist__content">

                    <div class="wishlist__product">

                        <div class="wishlist__product--desktop">

                            @if(count($address))

                            <table class="table">

                                <thead class="wishlist__thead">

                                    <tr>
                                        <th scope="col">Street</th>
                                        <th scope="col">Zip</th>
                                        <th scope="col">Town</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Action</th>
                                    </tr>

                                </thead>

                                <tbody class="wishlist__tbody">

                                    @foreach($address as $key)

                                    <tr id="{{$key->id}}">

                                        <td>{{$key->street}}</td>
                                        <td>{{$key->zip}}</td>
                                        <td>{{$key->town}}</td>
                                        <td>{{$key->country}}</td>
                                        <td><div class="wishlist__trash wishlist" data-id="{{$key->id}}"><a title="Remove this item icon-trash2 wishlist" class="remove" 
                                    href="#">×</a></div></td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            @else

                            <div class="text-center">

                                <img src="{{url('/public/not-found.jpg')}}">

                                <p>No Address Found.</p>

                            </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>
            
            </div>
         
      

      

    </main>

<script type="text/javascript">

    $('.wishlist__trash.wishlist').click(function(){

        id = $(this).attr('data-id');

        if (confirm('Do you want to remove this address?')) {

            $.ajax({

            url:'/trash_address',

            data:{id:id},

            cache:false,

            success:function(res){

              if (res) {

                $('#'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});

              }

            }

          }); 

        }else{

            return false;

        }

    });

</script>

@endsection



