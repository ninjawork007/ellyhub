@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<!-- <link rel="stylesheet" type="text/css" href="{{url('public/assets/admin/vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/assets/admin/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}"> -->
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <h4 class="card-title"><strong>{{$bundle->title}}</strong></h4>
                  <div class="col-md-12">
                    <a href="javascript:;" class="btn btn-outline-secondary btn-fw float-right add_product_to_bundle"><i class="fa fa-plus"></i></a>
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable" >
                      <thead>
                        <tr>
                          <th data-orderable="false">Product</th>
                          <th data-orderable="false">Image</th>
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
<div class="modal fade" id="product_bundle_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Products</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-body" method="post" action="{{route('product_bundle_product_save')}}">
        @csrf
        @if(count($products))
        <input type="hidden" name="bundle_id" value="{{$bundle->id}}">
        <select class="js-example-basic-multiple w-100" multiple="multiple" name="product_id[]" required="" >
            @foreach($products as $key)
            <option value="{{$key->id}}" <?php if(in_array($key->id, $bundle_product_id)){ echo 'selected';}?> >{{$key->name}}</option>
            @endforeach
        </select>
        
        <input type="submit" value="Save" class="btn btn-outline-secondary">
        @else
        <p class="">Please add products. <a href="{{route('add_product')}}">Add Product</a></p>
        @endif
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<!-- <script src="{{url('public/assets/admin/vendors/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{url('public/assets/admin/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
<script src="{{url('public/assets/admin/js/select2.js')}}"></script> -->
<script>
  var bundleid = "{{$bundle->id}}";
    $(document).ready(function() {
        var table = $("#myTable").DataTable({
            language: {"processing": "Please wait..."},
            dom: "frtip",
            serverSide: true,
            processing: true,
            stateSave: true,
            searching: false,
            ajax: {
                url: "{{route('ajax_get_bundle_products')}}", // json datasource
                type: "get", // method  , by default get
                cache: false,
                "data": function(data) {
                    data.status = $('#status').val();
                    data.bundleid = bundleid;
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
        $('#status').on('change', function() {
            table.draw();
        });
    });


$('body').on('click','.delete_product',function(){
  id = $(this).attr('id');
  table = $(this).attr('table');
  swal({
        title: "Do you want to delete this product?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url:"{{route('delete_product_bundle')}}",
            data:{id:id,table:table},
            cache:false,
            success:function(response){
              $('.error').html('<div class="alert alert-success alert-dismissible fade show" role="alert">Product remove successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              $('#'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
            }
          });
        } 
      });
});

$('body').on('click','.add_product_to_bundle',function(){
  $('#product_bundle_add').modal('show');
});
</script>
@endsection