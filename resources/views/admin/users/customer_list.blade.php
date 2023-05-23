@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Users</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="col-md-12">
                    <!-- <a href="{{route('add_product')}}" class="btn btn-outline-secondary btn-fw float-right"><i class="fa fa-plus"></i></a> -->
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable">
                      <thead>
                        <tr>
                          <th data-orderable="false">Name</th>
                          <th data-orderable="false">Email</th>
                          <th data-orderable="false">Mobile</th>
                          <th data-orderable="false">Date of joining</th>
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
<div class="modal fade bd-example-modal-lg show_document" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
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
                url: "{{route('ajax_get_customer')}}", // json datasource
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
    url:"{{route('update_vendor_status')}}",
    data:{id:id,value:value},
    cache:false,
    success:function(response){
      $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }
  });
});
$('body').on('click','.view_document',function(){
  $('.show_document').modal('show');
  $.ajax({
    url:"{{route('show_vendor_document')}}",
    data:{id:$(this).attr('id')},
    cache:false,
    success:function(response){
      var ress = jQuery.parseJSON(response);
      $('.modal-content').html(ress.data);
    }
  });
});
</script>
@endsection