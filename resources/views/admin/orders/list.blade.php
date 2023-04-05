@extends('layouts.admin')

@section('content')

<style type="text/css">
  td select.form-control {
    width: 100px;
}
p.package-title {
    font-size: 20px;
    text-align: center;
    font-weight: 600;
    color: #434343;
}
/*loader css*/
.lds-facebook {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-facebook div {
  display: inline-block;
  position: absolute;
  left: 8px;
  width: 16px;
  background: #fff;
  animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
}
.lds-facebook div:nth-child(1) {
  left: 8px;
  animation-delay: -0.24s;
}
.lds-facebook div:nth-child(2) {
  left: 32px;
  animation-delay: -0.12s;
}
.lds-facebook div:nth-child(3) {
  left: 56px;
  animation-delay: 0;
}
@keyframes lds-facebook {
  0% {
    top: 8px;
    height: 64px;
  }
  50%, 100% {
    top: 24px;
    height: 32px;
  }
}
</style>

<div class="main-panel">

        <div class="content-wrapper">

          <h4 class="card-title">Orders</h4>

          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card d-flex mb-3">
              <div class="col-md-3">
                <label>search</label>
                <input type="text" id="search" class="form-control" placeholder="Search by orderid">
              </div>
              <div class="col-md-3">
                <label>From Date</label>
                <input type="date" id="start_date" class="form-control">
              </div>
              <div class="col-md-3">
                <label>To Date</label>
                <input type="date" id="end_date" class="form-control">
              </div>
              <div class="col-md-3 mt-4">
                <label></label>
                <button class="btn btn-primary search" type="button">Search</button>
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">



              <div class="card">

                @include('alerts')

                <div class="error"></div>

                <div class="card-body">

                  <div class="table-responsive">
                    <table class="table table-hover" id="myTable" >
                      <thead>

                        <tr>

                          <th data-orderable="false">Order Id</th>

                          <th data-orderable="false">Customer</th>

                          <th data-orderable="false">Order Total</th>

                          <th data-orderable="false">Total Paid</th>

                          <th data-orderable="false">Delivery Type</th>

                          <th data-orderable="false">Payment Method</th>

                          <th data-orderable="false">Payment Status</th>
                          <th data-orderable="false">Delivery Status</th>
                          <th data-orderable="false">DOC</th>
                          

                          <th data-orderable="false">Action</th>

                        </tr>

                      </thead>

                      <tbody>

                      </tbody>

                    </table>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

        

      </div> 
<!-- Modal -->
<div class="modal fade" id="shipstation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Package Dimentions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-group" id="dimention-form" data-parsley-validate="">
          <input type="hidden" name="orderid" id="orderid" value="">
          <p class="package-title"></p>
          <div class="error-display">
            
          </div>
          <div class="row">
            <div class="col-md-12">
              Width: 
              <input type="text" name="width" id="width" placeholder="in inches" class="form-control" required data-parsley-type='number' data-parsley-trigger="keyup">
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-12">
              Length: 
              <input type="text" name="length" id="length" placeholder="in inches" class="form-control" required data-parsley-type='number' data-parsley-trigger="keyup">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              Height: 
              <input type="text" name="height" id="height" placeholder="in inches" class="form-control" required data-parsley-type='number' data-parsley-trigger="keyup">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              Weight: 
              <input type="text" name="weight" id="weight" placeholder="in grams" class="form-control" required data-parsley-type='number' data-parsley-trigger="keyup">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary chkprice" onclick="check_price()">Check Price</button>
        <button type="button" class="btn btn-primary send_to_shipstation" onclick="send_to_shipstation()">Send to ship station</button>
      </div>
    </div>
  </div>
</div>
<script>

    $(document).ready(function() {
        var table = $("#myTable").DataTable({
            searching:false,
            language: {"processing": "Please wait..."},

            dom: "frtip",

            serverSide: true,

            processing: true,

            stateSave: true,

            ajax: {

                url: "{{route('ajax_get_orders')}}", // json datasource

                type: "get", // method  , by default get

                cache: false,

                "data": function(data) {

                    data.search_ = $('#search').val();
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
                },

                error: function(data) { // error handling

                    $(".table-grid-error").html("");

                    $("#table-grid").append('<tbody class="table-grid-error"><tr><th colspan="6">No data found!</th></tr></tbody>');

                    $("#table-grid_processing").css("display", "none");

                },

                complete: function(data) {

                    

                }

            },

        });



        // search

        $('#key-search').on('keyup', function() {

            table.search(this.value).draw();

        });

        // account status

        $('.search').on('click', function() {
            table.draw();
        });
    });

$('body').on('change','.status',function(){
  id = $(this).attr('id');
  value = $(this).val();
  $.ajax({
    url:"{{route('update_product_status')}}",
    data:{id:id,value:value},
    cache:false,
    success:function(response){
      $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
  });
});

$('body').on('change','.delivery_type',function(){
  var id =  $(this).find(':selected').data('id');
  $('#orderid').val(id);
  var value = $(this).val();
  if (value=='shipstation') {
    $('#shipstation').modal('show');
  }
  if (value=='self') {
    update_shipping_type(id,value)
  }
});
function update_shipping_type(id,value) {
    $.ajax({
    url:"{{route('update_delivery_type')}}",
    data:{id:id,value:value},
    cache:false,
    success:function(response){
      $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

  });
}
$('body').on('click','.delete_row',function(){
  id = $(this).attr('id');
  table = $(this).attr('table');
  swal({
        title: "Do you want to delete this order?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url:"{{route('delete_order')}}",
            data:{id:id,table:table},
            cache:false,
            success:function(response){
              $('.error').html('<div class="alert alert-success alert-dismissible fade show" role="alert">Product deleted successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              $('#'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
            }
          });
        } 
      });
});
// $('body').on('change','.order_status',function(){
//   id = $(this).attr('id');
//   value = $(this).val();
//   table_key = $(this).attr('data-key');
//  change_status(id,value,table_key);
// });
$('body').on('change','.payment_status',function(){
  id = $(this).attr('id');
  value = $(this).val();
  table_key = $(this).attr('data-key');
 change_status(id,value,table_key);
});
$('body').on('change','.delivery_status',function(){
  id = $(this).attr('id');
  value = $(this).val();
  table_key = $(this).attr('data-key');
 change_status(id,value,table_key);
});
function change_status(orderid,value,table_key) {
   $.ajax({
    url:"{{route('update_order_parameter_admin')}}",
    data:{orderid:orderid,value:value,table_key:table_key},
    cache:false,
    success:function(response){
      $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
  });
}

function check_price(){
  var width = $.trim($('#width').val());
  var length = $.trim($('#length').val());
  var height = $.trim($('#height').val());
  var weight = $.trim($('#weight').val());
  var orderid = $.trim($('#orderid').val());
  if (width=='' || length=='' || height=='' || weight=='') {
    $('.error').html('<p class="text-danger">All fields are required.</p>');
    return false;
  }
  weight=convert_grams_to_ounces(weight).toFixed(2);
  $.ajax({
    url:"{{route('check_price_shipstation')}}",
    data:{width:width,length:length,height:height,weight:weight,orderid:orderid},
    cache:false,
    success:function(response){
      var ress = JSON.parse(response);
      console.log(ress.data[0]);
      $('.error-display').html('<p class="text-success">Price: $'+ress.data[0].shipmentCost+'</p>');
    }
  });
}

function convert_grams_to_ounces(grams) {
  return grams/28.3495;
}

function send_to_shipstation(){
  var width = $.trim($('#width').val());
  var length = $.trim($('#length').val());
  var height = $.trim($('#height').val());
  var weight = $.trim($('#weight').val());
  var orderid = $.trim($('#orderid').val());
  if (width=='' || length=='' || height=='' || weight=='') {
    $('.error-display').html('<p class="text-danger">All fields are required.</p>');
    return false;
  }
  weight=convert_grams_to_ounces(weight).toFixed(2);
  $.ajax({
    url:"{{route('ajax_send_to_shipstation')}}",
    data:{width:width,length:length,height:height,weight:weight,orderid:orderid},
    cache:false,
    success:function(response){
      var ress = JSON.parse(response);
      $('.error').html('<p class="text-danger">Delivery Status updated.</p>');
      $('#width').val('');$('#length').val('');$('#height').val('');$('#weight').val('');
      $('#shipstation').modal('hide');
    }
  });
}
</script>

@endsection