@extends('layouts.admin')

@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">My Sale</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="col-md-3">
                <label>Select Product</label>
                <select class="form-control" id="productid" name="productid">
                  <option value="">select Product</option>
                  @if($vendor->count())
                  @foreach($vendor as $key)
                  <option value="{{$key->id}}">{{$key->name}}</option>
                  @endforeach
                  @endif
              </select>
              </div>
              <div class="col-md-3">
                <label>Delivery status</label>
                <select class="form-control" id="delivery_status" name="delivery_status">
                  <option value="">select</option>
                  <option value="pending">Pending</option>
                  <option value="dispatch">Dispatch</option>
                  <option value="delivered">Delivered</option>
              </select>
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
                          <th data-orderable="false">Product</th>
                          <th data-orderable="false">Image</th>
                          <th data-orderable="false">Price</th>
                          <th data-orderable="false">Sale Price</th>
                          <th data-orderable="false">Order Status</th>
                          <th data-orderable="false">Payment Status</th>
                          <th data-orderable="false">Delivery Status</th>
                          <th data-orderable="false">Order Date</th>
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
                url: "{{route('ajax_get_sale')}}", 

                type: "get", 

                cache: false,

                "data": function(data) {

                    data.productid = $('#productid').val();
                    data.delivery_status = $('#delivery_status').val();

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



$('body').on('change','.order_status',function(){
  id = $(this).attr('id');
  value = $(this).val();
  table_key = $(this).attr('data-key');
 change_status(id,value,table_key);
});
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

function change_status(id,value,table_key) {
   $.ajax({
    url:"{{route('update_order_parameter')}}",
    data:{id:id,value:value,table_key:table_key},
    cache:false,
    success:function(response){
      $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
  });
}
</script>

@endsection