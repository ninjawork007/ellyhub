@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Delivery</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="col-md-12">
                    <!-- <a href="javascript:;" data-toggle="modal" data-target=".show_document" class="btn btn-outline-secondary btn-fw float-right"><i class="fa fa-plus"></i></a> -->
                    <form class="form-inline" data-parsley-validate="" action="{{route('save_delivery_slab')}}" method="post">
                      @csrf
                      <div class="form-group mb-2">
                        <input type="number" class="form-control" name="range_from" required="" placeholder="Range From">
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                        <input type="number" class="form-control" name="range_to" required="" placeholder="Range To">
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                        <input type="number" class="form-control" name="delivery_fee" required="" placeholder="Delovery fee">
                      </div>
                      <button type="submit" class="btn btn-primary mb-2">Add</button>
                    </form>
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable">
                      <thead>
                        <tr>
                          <th data-orderable="false">Price To</th>
                          <th data-orderable="false">Price From</th>
                          <th data-orderable="false">Delivery fee</th>
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
                url: "{{route('ajax_get_delivery_slab')}}", // json datasource
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
        $('body').on('click','.delete_row',function(){
        id = $(this).attr('id');
        table = $(this).attr('table');
        if (confirm("Are you sure to delete?")) {
          $.ajax({
            url:"{{route('delete_delivery_slab')}}",
            data:{id:id,table:table},
            cache:false,
            success:function(response){
              $('#'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
            }
          });
        }else{
          return false;
        }
      });
    });
</script>
@endsection