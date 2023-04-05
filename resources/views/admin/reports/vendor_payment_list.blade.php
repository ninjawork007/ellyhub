@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Vendor Payments</h4>
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
                          <th data-orderable="false">Vendor Name</th>
                          <th data-orderable="false">Vendor Email</th>
                          <th data-orderable="false">Total Earned</th>
                          <th data-orderable="false">Admin Comission</th>

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
            "columnDefs": [
    { "width": "20%" }],
            language: {"processing": "Please wait..."},

            dom: "frtip",

            serverSide: true,

            processing: true,

            stateSave: true,

            ajax: {

                url: "{{route('ajax_get_payments_reports')}}", // json datasource

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
</script>

@endsection