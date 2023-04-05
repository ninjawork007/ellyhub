@extends('layouts.admin')

@section('content')

<div class="main-panel">

        <div class="content-wrapper">

          <h4 class="card-title">Child Category</h4>

          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">



              <div class="card">

                @include('alerts')

                <div class="card-body">

                  <div class="col-md-12">

                    <a href="{{route('child_category_add')}}" class="btn btn-outline-secondary btn-fw text-right"><i class="fa fa-plus"></i></a>

                  </div>

                  <div class="table-responsive">

 

                    <table class="table table-hover">

                      <thead>

                        <tr>

                          <th>Name</th>

                          <th>Attributes</th>

                          <th>Category</th>

                          <th>Sub Category</th>

                          <th>Action</th>

                        </tr>

                      </thead>

                      <tbody>

                        @if(!$child_categories->isEmpty()) @foreach($child_categories as $key)

                        <tr id="{{$key->id}}">

                          <td> {{$key->name}}</td>

                          <td><a href="{{route('attribute',['child_category',$key->id])}}" class="btn btn-outline-primary btn-sm">Attribute</a></td>

                          <td> {{ App\Http\Controllers\CommonController::getCategoryName($key->category_id) }}</td>

						   <td> {{ App\Http\Controllers\CommonController::getSubCategoryName($key->sub_category_id) }}</td>

						  <td> 

                            <div>

                              <a href="{{route('edit_child_category',[$key->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>

                              <a href="javascript:;" class="btn btn-danger btn-sm" onclick="delete_row('{{$key->id}}','child_categories')"><i class="fa fa-trash"></i></a>

                            </div>

                          </td>

                        </tr>

                        @endforeach

                        @endif

                      </tbody>

                    </table>

{!! $child_categories->links() !!}
                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

       

      </div>

	  



@endsection







 

<!--div class="main-panel">

        <div class="content-wrapper">

          <h4 class="card-title">Child Category</h4>

          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">



              <div class="card">

                @include('alerts')

                <div class="card-body">

                  <div class="col-md-12">

                    <a href="{{route('child_category_add')}}" class="btn btn-outline-secondary btn-fw text-right"><i class="fa fa-plus"></i></a>

                  </div>

                  <div class="table-responsive">



                    <table class="table table-hover" id="myTable" >

                      <thead>

                        <tr>

                          <th data-orderable="false">Child Category</th>

                          <th data-orderable="false">Sub Category</th>

                          <th data-orderable="false">Category</th>

                          <th data-orderable="false">Attributes</th>

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

   var DisplayIMge = document.getElementById("ajaxdiv");

    DisplayIMge.innerHTML = "<img src='https://lh3.googleusercontent.com/proxy/vOiIaOGcSEwTnoSSxxDjw544v1dJDGw4OnMkWVOt0736mcMhv-SejL_tZvvRCGmdQ-OBtqEdyj1zDyIO9Y-0Nigc2VWQfsP4g_Mp' /><h3>Please wait while we load</h3>"

</script>

<script>

    $(document).ready(function() {

        var table = $("#myTable").DataTable({

            language: {"processing": "Please wait..."},

            dom: "frtip",

            serverSide: true,

            processing: true,

            ajax: {

                url: "{{route('ajax_get_child_category')}}", 

                type: "get", 

                cache: false,

                "data": function(data) {

                    data.status = $('#status').val();

                },

                error: function(data) {  

                    $(".table-grid-error").html("");

                    $("#table-grid").append('<tbody class="table-grid-error"><tr><th colspan="6">No data found!</th></tr></tbody>');

                    $("#table-grid_processing").css("display", "none");

                },

                complete: function(data) {

                    

                }

            },

        });

        

        $('#key-search').on('keyup', function() {

            table.search(this.value).draw();

      

        $('#status').on('change', function() {

            table.draw();

        });

    });



</script>

 