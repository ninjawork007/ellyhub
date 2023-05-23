@extends('layouts.admin')
@section('content')

<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Edit Membership</h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                @include('alerts')
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('update_membership')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$membership->id}}">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="title" value="{{$membership->title}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Price</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="number" required="" name="price" value="{{$membership->price}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Description</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" required="" name="description" id="tinymce">{{$membership->description}}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right btn-grad" value="Update">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{date('Y')}} <a href="javascript:;" target="_blank">openinvite</a>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
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