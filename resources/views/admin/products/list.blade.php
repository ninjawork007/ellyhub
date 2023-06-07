@extends('layouts.admin')
@section('content')
<div class="page-header no-gutters">
  <div class="d-md-flex m-b-15 align-items-center justify-content-between">
    <div class="align-items-center">
      <h2 class="header-title">Products</h2>
    </div>
    <div class="align-items-left">
      <div class="d-md-flex align-items-center justify-content-between">
        <a href="{{ URL('GetCategory') }}" target="_blank" class="btn btn-secondary "><i class="fa fa-download"></i> Fetch eBay Product</a>
      </div>
    </div>
    <div class="align-items-center">
      <div class="d-md-flex align-items-center justify-content-between">
        <a href="{{route('add_product')}}" class="btn btn-secondary "><i class="fa fa-plus"></i> Add New Product</a>
      </div>
    </div>
  </div>
</div>
<div class="card">
  @include('alerts')
  <div class="error"></div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover" id="myTable">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th data-orderable="false">Product</th>
            <th data-orderable="false">Vendor</th>
            <th data-orderable="false">Category</th>
            <th data-orderable="false">Price</th>
            <th data-orderable="false">Discount</th>
            <th data-orderable="false">Status</th>
            <th data-orderable="false">DOC</th>
            <th data-orderable="false">Ebay</th>
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

      language: {
        "processing": "Please wait..."
      },

      dom: "frtip",

      serverSide: true,

      processing: true,

      stateSave: true,

      ajax: {

        url: "{{route('ajax_get_products')}}", // json datasource

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

		console.log(data);
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



  $('body').on('change', 'select', function() {

    id = $(this).attr('id');

    value = $(this).val();

    $.ajax({
      type: "GET",
      url: "{{route('update_product_status')}}",
      async: false,
      data: {
        id: id,
        value: value
      },
      contentType: "application/json",
      cache: false,
      complete: function(response) {

        $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

      }

    });

  });

  $('body').on('click', '.delete_row', function() {

    id = $(this).attr('id');

    table = $(this).attr('table');

    value = $(this).attr('data-value');

    swal({

        title: "Do you want to delete this product?",

        icon: "warning",

        buttons: true,

        dangerMode: true,

      })

      .then((willDelete) => {

        if (willDelete) {

          $.ajax({

            url: "{{route('delete_product')}}",

            data: {
              id: id,
              table: table,
              value: value
            },

            cache: false,

            success: function(response) {

              $('.error').html('<div class="alert alert-success alert-dismissible fade show" role="alert">Product deleted successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

              $('#' + id + '').fadeOut(1200).css({
                'background-color': '#f2dede'
              });

            }

          });

        }

      });

  });
</script>

@endsection