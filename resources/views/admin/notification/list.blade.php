@extends('layouts.admin')

@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
.not-read {
    background-color: #282f3a26 !important;
}
.read {
    background-color: #f5f5f5 !important;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Notification</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="table table-hover" id="myTable" >
                      <thead>
                        <tr>
                          <th data-orderable="false">#</th>
                          <th data-orderable="false">Notification</th>
                          <th data-orderable="false">Date</th>
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
                url: "{{route('ajax_get_notification')}}", 

                type: "get", 

                cache: false,

                "data": function(data) {

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
        $('body').on('click','.mark_read', function() {
            var rowid = $(this).attr('id');
            $.ajax({
                url: "{{route('mark_read_notification')}}",
                data:  {rowid:rowid},
                cache: false,
                success: function(response) {
                  $('.no').html(response);
                  $('#'+rowid).removeClass('not-read');
                  $('#'+rowid).addClass('read');
                }
            });
        });
    });

</script>

@endsection