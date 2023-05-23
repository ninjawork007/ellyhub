@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Payment History</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              @if(Auth::user()->user_type!=='vendor')
              <div class="col-md-3">
                <label>Select Vendor</label>
                <select class="form-control" id="vendor" name="vendor">
                  <option value="">select vendor</option>
                  @if($vendor->count())
                    @foreach($vendor as $key)
                    <option value="{{$key->id}}">{{$key->name}} - {{$key->email}}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              @else
              <input type="hidden" id="vendor" name="vendor" value="{{Auth::user()->id}}">
              @endif
              <div class="col-md-3">
                <label>From Date</label>
                <input type="date" id="start_date" class="form-control">
              </div>
              <div class="col-md-3">
                <label>To Date</label>
                <input type="date" id="end_date" class="form-control">
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

                  <div class="col-md-12">

                  </div>

                  <div class="table-responsive">



                    <table class="table table-hover" id="myTable" >

                      <thead>

                        <tr>
                          <th data-orderable="false">Vendor Name</th>
                          <th data-orderable="false">From Date</th>
                          <th data-orderable="false">To Date</th>
                          <th data-orderable="false">Total Sale</th>
                          @if(Auth::user()->user_type!=='vendor')
                          <th data-orderable="false">Total Collection Feed</th>
                          <th data-orderable="false">Total Product Comission</th>
                          <th data-orderable="false">Fixed Fee</th>
                          <th data-orderable="false">GST On Comission</th>
                          <th data-orderable="false">Total Comission</th>
                          @endif
                          <th data-orderable="false">Total Payment</th>
                          
                          <th data-orderable="false">Payment Date</th>
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

                url: "{{route('ajax_get_payments_history')}}", // json datasource

                type: "get", // method  , by default get

                cache: false,

                "data": function(data) {

                    data.vendor = $('#vendor').val();
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
      baseurl = "{{url('admin/payment_history_download/?')}}";
      if ($('#vendor').val()!='') {
        vendor = 'vendor='+$('#vendor').val();
      }else{
        vendor='';
      }
      
      if ($('#start_date').val()=='') {
        start_date = '';
      }else{
        start_date = '&start_date='+$('#start_date').val();
      }

       if ($('#end_date').val()=='') {
        end_date = '';
      }else{
        end_date = '&end_date='+$('#end_date').val();
      }
      
      window.location.href=baseurl+vendor+start_date+end_date;
    }
</script>

@endsection