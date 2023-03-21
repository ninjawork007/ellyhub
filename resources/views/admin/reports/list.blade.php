@extends('layouts.admin')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">

        <div class="content-wrapper">
          <h4 class="card-title">Product stock report</h4>

          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
            	@if(Auth::user()->user_type!=='vendor')
              <div class="col-md-3">
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
                <select class="form-control" id="category" name="category">
                  <option value="">select category</option>
                  @if($category->count())
                  @foreach($category as $key)
                  <option value="{{$key->id}}">{{$key->name}}</option>
                  @endforeach
                  @endif
                </select>
              </div>
              <div class="col-md-3" id="sub_category">
              </div>
              <div class="col-md-3" id="child_category">
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

                          <th data-orderable="false">Product Name</th>
                          <th data-orderable="false">Vendor Name</th>
                          <th data-orderable="false">Price</th>
                          <th data-orderable="false">Discount</th>
                          <th data-orderable="false">GST</th>
                          <th data-orderable="false">Comission</th>
                          <th data-orderable="false">Produc Stock</th>
                          <!-- <th data-orderable="false">Total sale</th> -->

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
    searching: false,
            language: {"processing": "Please wait..."},

            dom: "Bfrtip",
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
            serverSide: true,

            processing: true,

            stateSave: true,

            ajax: {

                url: "{{route('ajax_get_product_reports')}}", // json datasource

                type: "get", // method  , by default get

                cache: false,

                "data": function(data) {

                    data.status = $('#status').val();
                    data.category = $("#category").val();
                    data.sub_category = $("#sub_category_").val();
                    data.child_category = $("#child_category_").val();
                    data.vendor = $("#vendor").val();
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

        $('#category').on('change', function() {
            table.draw(this.value);
        });
        $('#vendor').on('change', function() {
            table.draw(this.value);
        });

        $('body').on('change','#sub_category_',function() {
            table.draw(this.value);
        });

        $('body').on('change','#child_category_',function() {
            table.draw(this.value);
        });
    });

    $('#category').change(function(){
      $.ajax({
        url:"{{route('get_sub_category_admin')}}",
        data:{categoryid:$(this).val()},
        cache:false,
        success:function(response){
          console.log(response);
          $('#sub_category').html(response);
        }
      });
    });

    $('body').on('change','#sub_category_',function(){
      $.ajax({
        url:"{{route('get_child_category_admin')}}",
        data:{categoryid:$('#category').val(),sub_categoey:$('#sub_category_').val()},
        cache:false,
        success:function(response){
          $('#child_category').html(response);
        }
      });
    });

    function download_csv(){
      baseurl = "{{url('admin/product_stock_report_download/?')}}";
      if ($('#vendor').val()!='') {
        vendor = 'vendor='+$('#vendor').val();
      }else{
        vendor='';
      }
      if ($('#category').val()!='') {
        category = '&category='+$('#category').val();
      }else{
        category='';
      }

      if ((typeof $('#sub_category_').val() !== 'undefined') && $('#sub_category_').val()!='') {
        sub_category= '&sub_category='+$('#sub_category_').val();
      }else{
        sub_category='';
      }
      if ( (typeof $('#child_category_').val() !== 'undefined') && $('#child_category_').val()!='') {
        child_category = '&child_category='+$('#child_category_').val();
      }else{
        child_category='';
      }
      
      window.location.href=baseurl+vendor+category+sub_category+child_category;
    }
</script>

@endsection