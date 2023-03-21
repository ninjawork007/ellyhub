@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Wallet</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="col-md-12">
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable">
                      <thead>
                        <tr>
                          <th data-orderable="false">Name</th>
                          <th data-orderable="false">Email</th>
                          <th data-orderable="false">Mobile</th>
                          <th data-orderable="false">Balance</th>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add balance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-inline" method="post" action="{{route('update_balance')}}" data-parsley-validate="" >
          @csrf
          <input type="hidden" name="id" id="id" value="">
          <div class="form-group mx-sm-6 mb-2">
            <input type="text" class="form-control" required="" name="amount" placeholder="0" min="0" max="20000" step="100" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="number">
          </div>
          <button type="submit" class="btn btn-primary mb-2">Add Balance</button>
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
                url: "{{route('ajax_get_customer_wallet')}}", // json datasource
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

    function show_modal(id) {
      $('#id').val(id);
      $('#exampleModalCenter').modal('show');
    }
</script>
@endsection