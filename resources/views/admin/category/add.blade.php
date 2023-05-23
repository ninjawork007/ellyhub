@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Category</h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('save_category')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="name">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Slug</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="slug" name="slug" >
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Category Icon</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" required="" accept="image/x-png,image/svg" name="icon">
                            <small> only png,svg icon allow</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Category Banner</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" accept="image/x-jpg,image/jpeg" name="banner">
                            <small> only JPG, JPEG images are allowed</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Submit">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        $('#title').change(function(e) {
          $('#slug').val(convertToSlug($(this).val()));
        });

        function convertToSlug(Text){
            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        }
      </script>
@endsection