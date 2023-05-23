@extends('layouts.admin')
@section('content')

<div class="page-header no-gutters">
  <div class="d-md-flex align-items-center justify-content-between">
    <div class="align-items-center">
      <h2 class="header-title">Vendors</h2>
    </div>
    <div class="align-items-center">
      <div class="d-md-flex align-items-center justify-content-between">
        <div class="col-md-6">
          <select class="form-control" id="status" name="status">
            <option value="">select Status</option>
            <option value="0">Pending</option>
            <option value="1">Approved</option>
            <option value="2">Dis-approved</option>
          </select>
        </div>
        <div class="col-md-6">
          <a href="javascript:;" onclick="download_csv()" class="btn btn-secondary">Export CSV</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  @include('alerts')
  <div class="error"></div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-8">
      </div>
      <div class="col-lg-4 text-right">
        <a href="{{route('add_vendor')}}" class="btn btn-primary"><i class="anticon anticon-plus-circle m-r-5"></i> <span>Add Vendor</span></a>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover" id="myTable">
        <thead>
          <tr>
            <th data-orderable="false">Name</th>
            <th data-orderable="false">Email</th>
            <th data-orderable="false">Mobile</th>
            <th data-orderable="false">Status</th>
            <th data-orderable="false">Verification</th>
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

<script>
  $(document).ready(function() {
    var table = $("#myTable").DataTable({
      searching: false,
      language: {
        "processing": "Please wait..."
      },
      dom: "frtip",
      serverSide: true,
      processing: true,
      stateSave: true,
      ajax: {
        url: "{{route('ajax_get_vendor')}}", // json datasource
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
    $('body').on('change', '.change_status', function() {
      id = $(this).attr('id');
      val = $(this).val();
      $.ajax({
        url: "{{route('update_vendor_status')}}",
        data: {
          id: id,
          value: val
        },
        cache: false,
        success: function(response) {
          if (response) {
            alert("Status update successfully.");
          }
        }
      });
    });
  });


  function download_csv() {
    baseurl = "{{url('admin/download_vendor_csv/?')}}";
    if ($('#status').val() != '') {
      status = 'status=' + $('#status').val();
    } else {
      status = '';
    }

    window.location.href = baseurl + status;
  }
</script>
@endsection