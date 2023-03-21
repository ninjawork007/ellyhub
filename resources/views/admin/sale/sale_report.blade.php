@extends('layouts.admin')

@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Sale Report</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              @if(Auth::user()->user_type!=='vendor')
              <div class="col-md-3">
                <label>Select Vendor</label>
                <select class="form-control" id="vendorid" name="vendorid">
                  <option value="">Select</option>
                  @if($vendor->count())
                  @foreach($vendor as $key)
                  <option value="{{$key->id}}">{{$key->name}} - {{$key->email}}</option>
                  @endforeach
                  @endif
              </select>
              </div>
              @else
              <input type="hidden" id="vendorid" name="vendorid" value="{{Auth::user()->id}}">
              @endif
              <div class="col-md-3">
                <label>From Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
              </div>
              <div class="col-md-3">
                <label>To Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
              </div>
              <div class="col-md-3 mt-4">
                <label></label>
                <button class="btn btn-primary search" type="button">Search</button>
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="col-md-4">
                <a href="javascript:;" onclick="download_csv()" class="btn btn-primary">Export CSV</a>
              </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="table table-hover" id="myTable" >
                      <thead>
                        <tr>
                          <th data-orderable="false">Vendor Name</th>
                          <th data-orderable="false">Order Date</th>
                          <th data-orderable="false">Order No</th>
                          <th data-orderable="false">Product</th>
                          <th data-orderable="false">Quantity</th>
                          <th data-orderable="false">Taxable Amount</th>
                          <th data-orderable="false">GST</th>
                          <th data-orderable="false">Shipping Charge</th>
                          <th data-orderable="false">Total Sale Value</th>
                          <th data-orderable="false">Comission Fee</th>
                          <th data-orderable="false">Collection Fee</th>
                          <th data-orderable="false">Fixed Fee</th>
                          <th data-orderable="false">GST (Markitplace)</th>
                          <th data-orderable="false">Total Comission Amount</th>
                          <th data-orderable="false">Vendor Payable Amount</th>
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
            fixedHeader:true,
            searching:false,
            language: {"processing": "Please wait..."},
            dom: "frtip",
            serverSide: true,
            processing: true,
            stateSave: true,
            ajax: {
                url: "{{route('ajax_sale_report')}}", 
                type: "get", 
                cache: false,
                "data": function(data) {
                    data.vendorid = $('#vendorid').val();
                    data.start_date = $('#start_date').val();
                    data.end_date = $('#end_date').val();
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

    });

function download_csv(){
      baseurl = "{{url('admin/sale_report_download/?')}}";
      if ($('#vendorid').val()!='') {
        vendor = 'vendorid='+$('#vendorid').val();
      }else{
        vendor='';
      }
      if ($('#start_date').val()!='') {
        start_date = '&start_date='+$('#start_date').val();
      }else{
        start_date='';
      }

      if ($('#end_date').val()!='') {
        end_date = '&end_date='+$('#end_date').val();
      }else{
        end_date='';
      }
      
      window.location.href=baseurl+vendor+start_date+end_date;
    }

</script>

@endsection