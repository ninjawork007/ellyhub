@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Stocks</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="col-md-12">
                    <a href="{{route('add_product')}}" class="btn btn-outline-secondary btn-fw float-right"><i class="fa fa-plus"></i></a>
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable" >
                      <thead>
                        <tr>
                          <th data-orderable="false">Product</th>
                          <th data-orderable="false">Stock</th>
                          <th data-orderable="false">Stock Status</th>
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
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{date('Y')}} <a href="javascript:;" target="_blank">openinvite</a>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
<!-- Modal -->
<div class="modal fade" id="stock_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
     <div class="error"></div>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form data-parsley-validate="" id="add_stock_form">
          <div class="form-group">
            <input type="hidden" name="id" value="" id="product_id">
            <input type="text" class="form-control" name="value" aria-describedby="emailHelp" placeholder="eg:- 100" data-parsley-type="digits" min="1" data-parsley-trigger="keyup">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        var table = $("#myTable").DataTable({
            language: {"processing": "Please wait..."},
            dom: "frtip",
            serverSide: true,
            processing: true,
            stateSave: true,
            ajax: {
                url: "{{route('ajax_get_product_stock')}}", // json datasource
                type: "get", // method  , by default get
                cache: false,
                "data": function(data) {
                    data.status = $('#status').val();
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

$('body').on('change','select',function(){
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

$('body').on('click','.add_stock',function(){
  id = $(this).attr('id');
  $('#stock_modal').modal('show');
  $('#product_id').val(id);
});

$('#add_stock_form').submit(function(e){
  e.preventDefault();
  if (!$(this).parsley().validate()) {
    return false;
  }
  $.ajax({
    url:"{{route('add_stock')}}",
    data:$(this).serialize(),
    cache:false,
    success:function(response){
      var ress = JSON.parse(response);
      if (ress.success) {
        $('.error').html(' <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success</strong>'+ress.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        $("#myTable").DataTable().ajax.reload(null, false);
      }else{
        $('.error').html(' <div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Success</strong>'+ress.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      }
    }
  });
});

$('body').on('click','.remove_stock',function(){
  id = $(this).attr('id');
  swal({
        title: "Are you sure?",
        text: "Once stockout, you will not be able to recover data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url:'{{route("stock_out")}}',
            data:{id:id},
            cache:false,
            success:function(response){
              if (response) {
                $("#myTable").DataTable().ajax.reload(null, false);
              }
            }
          });
        } 
      });
});
</script>
@endsection