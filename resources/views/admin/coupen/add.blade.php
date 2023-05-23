@extends('layouts.admin')
@section('content')
<style type="text/css">
hr {
    border-top: 1px solid #eaeaea;
}
input#code { text-transform: uppercase; }
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Coupen</h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                @include('alerts')
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('save_coupen')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="name" id="title">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Slug<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="slug" id="slug" readonly="">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Code<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="code" id="code">
                            <small class="text-danger">Do not use space and special characters.</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Discount Type<span>*</span></label>
                          <div class="col-sm-9">
                            <select class="form-control" required="" name="discount_type">
                                <option value="">Select Discount Type</option>
                                <option value="percent">Percentage</option>
                                <option value="fixed">Fixed</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Discount<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" required="" name="discount">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Expiry Date<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="date" class="form-control" required="" name="expiry_date">
                          </div>
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