@extends('layouts.admin')

@section('content')
<div class="main-content">
  <div class="page-header">
    <h2 class="header-title">Catories</h2>
    <div class="header-sub-title">
      <nav class="breadcrumb breadcrumb-dash">
        <a href="{{route('admin_dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
        <a class="breadcrumb-item" href="javascript:void(0);">Catalog</a>
        <span class="breadcrumb-item active">Categories</span>
      </nav>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row m-b-30">
        <div class="col-lg-8">
          <ul class="inner-menu d-flex">
            <li class="m-r-15"><a class="btn btn-primary btn-tone" href="{{route('category_list')}}">Main Categories</a></li>
            <li class="m-r-15"><a class="btn btn-primary btn-tone" href="{{route('sub_category_list')}}">Sub Categories</a></li>
            <li class="m-r-15"><a class="btn btn-primary btn-tone" href="{{route('child_category_list')}}">Child Categories</a></li>
          </ul>
        </div>
        <div class="col-lg-4 text-right">
          <a href="{{route('add_category')}}" class="btn btn-success"><i class="anticon anticon-plus"></i>Add Main Category</a>
        </div>
      </div>
      @include('alerts')
      <div class="error"></div>
      <div class="m-t-25">
        <div class="table-responsive">
          <table id="data-table" class="table">
            <thead>
              <tr>
              <th></th>
                <th>Name</th>
                <th>Attributes</th>
                <th>Date of created</th>
                <th>Home Category</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if(!$category->isEmpty()) @foreach($category as $key)
              <tr id="{{$key->id}}">
                <td>
                  <?php if ($key->image) { ?><img src="{{url('public/'.$key->image)}}" alt="image" class="bg-light" />
                  <?php } ?></td>
                  <td>{{$key->name}}</td>
                <td><a href="{{route('attribute',['category',$key->id])}}" class="btn btn-outline-primary btn-sm">Attribute</a></td>
                <td>{{date('Y F, d',strtotime($key->created_at))}}</td>
                <td>
                  <select class="form-control" name="home_screen" id="home_screen">
                    <option value="yes" data-id="{{$key->id}}" {{ ($key->home_screen) == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" data-id="{{$key->id}}" {{ ($key->home_screen) == 'no' ? 'selected' : '' }}>No</option>
                  </select>
                </td>
                <td>
                  <select class="form-control" name="status" id="status">
                    <option value="active" data-id="{{$key->id}}" {{ ($key->isactive) == 'active' ? 'selected' : '' }}>Activated</option>
                    <option value="notactive" data-id="{{$key->id}}" {{ ($key->isactive) == 'notactive' ? 'selected' : '' }}>Deactivated</option>
                  </select>
                </td>
                <td>
                  <div>
                    <a href="{{route('edit_category',[$key->id])}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" class="btn btn-outline-danger btn-sm" onclick="delete_row('{{$key->id}}','categories')"><i class="fa fa-trash"></i></a>
                  </div>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
          {!! $category->links() !!}
        </div>
      </div>
    </div>
  </div>
  <script>
    /* On Change Status of Home Category*/

    $('select[name="home_screen"]').change(function() {

      $('.error').html('');

      var id = $(this).find(':selected').data('id');

      var value = $(this).find(':selected').val();

      var name = $(this);

      $.ajax({

        url: "{{route('home_category')}}",

        data: {
          id: id,
          value: value
        },

        cache: false,

        success: function(response) {

          if (response == 1) {

            $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

          } else {

            $('.error').html('<div class="alert alert-error alert-dismissible fade show" role="alert">We can use only Three Home Category !!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            $(name).prop('selectedIndex', 0);

          }

        }

      });

    });

    /* On Change Status of Category*/

    $('select[name="status"]').change(function() {

      $('.error').html('');

      var id = $(this).find(':selected').data('id');

      var value = $(this).find(':selected').val();

      var name = $(this);

      $.ajax({

        url: "{{route('category_status')}}",

        data: {
          id: id,
          value: value
        },

        cache: false,

        success: function(response) {

          if (response == 1) {

            $('.error').html('<div class="alert alert-info alert-dismissible fade show" role="alert">Status update successfully.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

          } else {

            $('.error').html('<div class="alert alert-error alert-dismissible fade show" role="alert">error while updating status !!!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            $(name).prop('selectedIndex', 0);

          }

        }

      });

    });
  </script>

  @endsection