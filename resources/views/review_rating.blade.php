@extends('layouts.web')
@section('pagetitle')
Review And Rating
@endsection
@section('pagebodyclass')
single-product full-width normal light-bg
@endsection
@section('content')
<style>
form.reviewRating {
    padding: 45px 17px;
}
.card.main-form {
    padding: 14px;
}
</style>
<div class="breadcrumb-section" style="display:none">
    <div class="container">
        <ul class="breadcrumb" aria-label="breadcrumb">
            <li class="breadcrumb-item "><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Review And Rating</li>
        </ul>
    </div>
</div>
@include('common.alerts')
<div class="product-detail-page light-grey-bg">
    @if($products->isEmpty())
    <section class="section p-5">
        <div class="container-fluid">
            <div class="row main-product-div">
                <p>No Data Found.</p>
            </div>
        </div>
    </section>
    @else
    @foreach($products as $key)
    <?php
    $review = DB::table('reviews')->where([['productid','=',$key->productid],['userid','=',Auth::user()->id]])->first();
    ?>
<section class="section p-5">
    <div class="container-fluid">
        <div class="row main-product-div">
            <div class="col-sm-6">
                <div class="card" style="width: 18rem;">
                  <img src="{{url('public/'.$key->image)}}" class="card-img-top" alt="">
                  <div class="card-body">
                    <p class="card-text">{{$key->product_name}}</p>
                  </div>
                </div>
            </div>
            <div class="col-sm-6">
                @if($review)
                <form action="{{route('update_review')}}" class="reviewRating" method="post">
                @else
                <form action="{{route('submit_review')}}" class="reviewRating" method="post">
                @endif
                    @csrf
                    <input type="hidden" name="product_id" value="{{$key->productid}}">
                    <input type="hidden" name="userid" value="{{Auth::user()->id}}">
                    <input type="hidden" name="orderid" value="{{$orderid}}">
                <div class="card main-form">
                  <label for="">Rating:</label>
                  <select name="rating" required>
                    <option value="1" <?php if(@$review->rating==1){echo 'selected';}?> >1 Star </option>
                    <option value="2" <?php if(@$review->rating==2){echo 'selected';}?> >2 Stars </option>
                    <option value="3" <?php if(@$review->rating==3){echo 'selected';}?> >3 Stars </option>
                    <option value="4" <?php if(@$review->rating==4){echo 'selected';}?> >4 Stars </option>
                    <option value="5" <?php if(@$review->rating==5){echo 'selected';}?> >5 Stars </option>
                  </select>
                  <br />
                  <label for="">Write a Review!</label>
                  <textarea name="review" cols="35" rows="5" placeholder="Write your review in here, please let the next customers know how your experience was!">{{@$review->comment}}</textarea>
                   <br />
                   <br />
                  <button type="submit" class="btn btn-primary">Submit Review!</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endforeach
@endif
</div>

@endsection