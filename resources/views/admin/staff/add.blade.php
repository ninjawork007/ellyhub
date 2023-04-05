@extends('layouts.admin')
@section('content')
<style type="text/css">
hr {
    border-top: 1px solid #eaeaea;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Staff</h4>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                @include('alerts')
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('save_staff')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="name">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" required="" name="email">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Password<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" required="" name="password">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Mobile<span>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="mobile">
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
@endsection