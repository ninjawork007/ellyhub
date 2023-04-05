@extends('layouts.admin')
@section('content')
<script src="https://cdn.tiny.cloud/1/c2qcxj5f1jt89kcmq754gz0psi44pl01zjx6zehocfgeeq4j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#description',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
   });
  
  </script>
<div class="main-panel">
        <div class="content-wrapper">
          @include('common.alerts')
          <h4 class="card-title">Add Attribute</h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('save_page')}}" data-parsley-validate="">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Page Name</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" required="" id="page_name" name="page_name">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Page Title</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" required="" id="page_title" name="page_title">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Link</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" required="" id="link" name="link" readonly="">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Description</label>
                          <div class="col-sm-12">
                            <textarea class="form-control" id="description" name="description" required=""></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Seo Title</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" id="seo_title" name="seo_title">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Seo Tags</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" id="seo_tags" name="seo_tags">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Seo Description</label>
                          <div class="col-sm-12">
                            <textarea  class="form-control" name="seo_description" rows="5"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row add_div"></div>
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Submit">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
       
        <!-- partial -->
      </div>
      <script type="text/javascript">
        $('#page_name').keyup(function(e) {
          $('#link').val(convertToSlug($(this).val()));
        });
        function convertToSlug(Text){
            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        }
      </script>
@endsection