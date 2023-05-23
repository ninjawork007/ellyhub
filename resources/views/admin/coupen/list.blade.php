@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Coupens</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="col-md-12">
                    <a href="{{route('add_coupen')}}" class="btn btn-outline-secondary btn-fw float-right"><i class="fa fa-plus"></i></a>
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable" >
                      <thead>
                        <tr>
                          <th data-orderable="false">Name</th>
                          <th data-orderable="false">Code</th>
                          <th data-orderable="false">Discount Type</th>
                          <th data-orderable="false">Discount</th>
                          <th data-orderable="false">Expiry Date</th>
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
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{date('Y')}} <a href="javascript:;" target="_blank">Bazarhat99</a>. All rights reserved.</span>
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
                url: "{{route('ajax_get_coupen')}}", // json datasource
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


$('body').on('click','.delete_row',function(){
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
            url:"{{route('delete_row')}}",
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

</script>
@endsection