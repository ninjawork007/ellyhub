@extends('layouts.admin')
@section('content')
<div class="page-header no-gutters">
  @if(count($orders))
  <div class="d-md-flex align-items-md-center justify-content-between">
    <div class="media m-v-10 align-items-center">
      <div class="avatar avatar-image avatar-lg">
      <img src="{{url('public/assets/web/images/favicon/apple-touch-icon.png')}}" alt="Logo">
      </div>
      <div class="media-body m-l-15">
        <h4 class="m-b-0">Vendor name</h4>
        <span>Vendor Email</span>
      </div>
    </div>
    <form class="make-payment-col d-md-flex align-items-center d-none" id="make_payment" method="post" action="{{route('make_vendor_payment')}}">
      @csrf
      <input type="hidden" name="vendor_id" id="vendor_id" value="">
      <input type="hidden" name="orderids" value="{{implode(',',$order_ids)}}">
      <div class="media align-items-center m-r-40 m-v-5">
        <div class="avatar avatar-icon avatar-lg avatar-blue"><i class="anticon anticon-dollar"></i></div>
        <div class="m-l-10">
          <h2 class="m-b-0 text-primary">{{number_format($final_order_total,2)}}</h2>
          <span>Total</span>
          <input type="text" hidden="" class="form-control" id="total_payment" name="total_amount" value="{{number_format($final_order_total,2)}}">
        </div>
      </div>
      <div class="media align-items-center m-r-40 m-v-5">
        <div class="avatar avatar-icon avatar-lg avatar-cyan"><i class="anticon anticon-user"></i></div>
        <div class="m-l-10">
          <h2 class="m-b-0 text-success">{{number_format($final_admin_comission,2)}}</h2>
          <span>Admin Comission</span>
          <input type="text" hidden="" class="form-control" id="" name="admin_comission" value="{{number_format($final_admin_comission,2)}}">
        </div>
      </div>
      <div class="media align-items-center m-r-40 m-v-5">
        <div class="avatar avatar-icon avatar-lg avatar-red"><i class="anticon anticon-shop"></i></div>
        <div class="m-l-10">
          <h2 class="m-b-0 text-danger">{{number_format($final_payable_amount,2)}}</h2>
          <span>Vendor Payment</span>
          <input type="text" hidden="" class="form-control" id="" name="vendor_payment" value="{{number_format($final_payable_amount,2)}}">
        </div>
      </div>
      <input type="hidden" name="total_collection_fee" value="{{number_format($final_total_collection_fee,2)}}">
      <input type="hidden" name="total_product_comission" value="{{number_format($final_total_product_comission,2)}}">
      <input type="hidden" name="total_fixed_fee" value="{{number_format($final_total_fixed_fee,2)}}">
      <input type="hidden" name="total_gst_on_comission" value="{{number_format($final_total_gst_on_comission,2)}}">
      <input type="hidden" name="start_date" value="{{$start_date}}">
      <input type="hidden" name="end_date" value="{{$end_date}}">
      <div class="media align-items-center m-v-5">
        <button class="btn btn-secondary btn-lg pay" type="button">Pay</button>
      </div>
    </form>
  </div>
  @else
  <h2 class="header-title">Vendor Payments</h2>
  @endif
</div>
<div class="card">
  <div class="card-body">
    <div class="row align-items-md-center">
      <div class="col-md-3">
        <label>Select Vendor</label>
        <select class="custom-select" id="vendor" name="vendor">
          <option value="">select vendor</option>
          @if($vendor_list->count())
          @foreach($vendor_list as $key)
          <option value="{{$key->id}}" <?php if ($key->id == $vendor_id) {
            echo 'selected';
          } ?>>{{$key->name}} - {{$key->email}}</option>
          @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-3">
        <label>Start Date</label>
        <input type="date" class="form-control" id="startdate" name="startdate" value="{{$start_date}}">
      </div>
      <div class="col-md-3">
        <label>End Date</label>
        <input type="date" class="form-control" id="enddate" name="enddate" value="{{$end_date}}">
      </div>
      <div class="col-md-3">
        <label>&nbsp;</label>
        <button class="btn btn-primary search" type="button">Search</button>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    @include('alerts')
    <div class="error"></div>
    <div class="table-responsive">
      <table class="table table-hover" id="myTable">
        <thead>
          <tr>
            <th data-orderable="false">Order Id</th>
            <th data-orderable="false">Order Date</th>
            <th data-orderable="false">Order's Total</th>
            <th data-orderable="false">Admin Comission</th>
            <th data-orderable="false">Vendor's Amount</th>
          </tr>
        </thead>
        <tbody>
          @if(count($orders))
          @foreach($orders as $key)
          <tr>
            <td>{!! $key['order_id'] !!}</td>
            <td>{{$key['created_date']}}</td>

            <td>₹{{$key['order_total']}}</td>
            <td>₹{{$key['admin_comission']}}</td>
            <td>₹{{$key['payable_amount']}}</td>
          </tr>

          @endforeach
          @endif
        </tbody>
        @if(count($orders))
        <tfoot>
          <tr>
            <th data-orderable="false"></th>
            <th data-orderable="false">Total</th>
            <th data-orderable="false">{{number_format($final_order_total,2)}}</th>
            <th data-orderable="false">{{number_format($final_admin_comission,2)}}</th>
            <th data-orderable="false">{{number_format($final_payable_amount,2)}}</th>
          </tr>
          </thead>
          @endif
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.paytovendor').click(function() {
    var vendorid = $(this).data('id');
    var vendor_payment = $(this).attr('data-vendor-payment');
    var admin_comission = $(this).attr('data-commission');

    var total_product_comission = $(this).attr('data-product-comission');
    var total_collection_fee = $(this).attr('data-collection-fee');
    var total_fixed_fee = $(this).attr('data-fixed-fee');
    var total_admin_gst = $(this).attr('data-admin-gst');
    $('#payment_modal').modal('show');
    $('#vendor_id').val(vendorid);
    $('#vendor_payment').val(parseFloat(vendor_payment).toFixed(2));
    $('#admin_comission').val(parseFloat(admin_comission).toFixed(2));

    $('#product_comission').val(parseFloat(total_product_comission).toFixed(2));
    $('#collection_fee').val(parseFloat(total_collection_fee).toFixed(2));
    $('#fixed_fee').val(parseFloat(total_fixed_fee).toFixed(2));
    $('#gst_on_comission').val(parseFloat(total_admin_gst).toFixed(2));
  });

  $('#form_payment').submit(function(e) {
    e.preventDefault();
    if (!$('#checkbox_').is(":checked")) {
      alert("Please confirm by click checkbox.");
      return false;
    }
    if ($('#vendor_payment').val() == '0.00') {
      alert("No payments for this vendor");
      return false;
    }

    $('#form_payment')[0].submit();
  });

  $('.search').click(function() {
    baseurl = "{{url('/admin/vendor-payments')}}/?search=true&vendorid=" + $('#vendor').val() + "&startdate=" + $('#startdate').val() + "&enddate=" + $('#enddate').val();
    window.location.href = baseurl;
  });

  function download_csv() {
    baseurl = "https://bazarhat99.com/admin/vendor_payment_report_download?";
    if ($('#vendor').val() != '') {
      vendor = 'vendor=' + $('#vendor').val();
    } else {
      vendor = '';
    }
    window.location.href = baseurl + vendor;
  }


  $('.pay').click(function() {
    $('#vendor_id').val($('#vendor').val());
    if ($('#total_payment').val() < 1) {
      alert("No amount to pay.");
      return false;
    }
    if ($('#vendor').val() == '') {
      alert("No vendor selected.");
      return false;
    }

    $('#make_payment').submit();
  });
</script>
@endsection