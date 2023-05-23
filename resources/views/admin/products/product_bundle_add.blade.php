@extends('layouts.admin')
@section('content')
<style type="text/css">
.form-control.readonly {
    background-color: #eaeaea;
    pointer-events: none;
}
hr {
    border-top: 1px solid #eaeaea;
}
</style>
<script src="https://cdn.tiny.cloud/1/c2qcxj5f1jt89kcmq754gz0psi44pl01zjx6zehocfgeeq4j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
      placeholder: "Add description..."
   });
  </script>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Bundle</h4>
          <div class="row">
            @include('alerts')
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('save_product_bundle')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Title<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="name">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Slug<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control readonly" required="" id="slug" name="slug">
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">image<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" required="" name="image">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product Price<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="product_price" data-parsley-type="digits">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Sale Price<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="sale_price" data-parsley-type="digits">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">GST<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="gst" data-parsley-type="digits">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" name="description"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row col-md-9">
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