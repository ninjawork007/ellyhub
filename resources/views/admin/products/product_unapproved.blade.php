@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Disapproved Products</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="col-md-12">
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable" >
                      <thead>
                        <tr>
                          <th data-orderable="false">Product</th>
                          <th data-orderable="false">Vendor</th>
                          <th data-orderable="false">Category</th>
                          <th data-orderable="false">Orignal Price</th>
                          <th data-orderable="false">Sale Price</th>
                          <th data-orderable="false">Status</th>
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
                url: "{{route('ajax_get_product_unapproved')}}", // json datasource
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

$('body').on('click','.delete_row',function(){
  id = $(this).attr('id');
  table = $(this).attr('table');
  value = $(this).attr('data-value');
  swal({
        title: "Do you want to recover this product?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url:"{{route('delete_product')}}",
            data:{id:id,table:table,value:value},
            cache:false,
            success:function(response){
              $('.error').html('<div class="alert alert-success alert-dismissible fade show" role="alert">Product deleted successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
              $('#'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
            }
          });
        } 
      });
});
</script>
@endsection