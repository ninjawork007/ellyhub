@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Add Vendor</h4>
          @include('alerts')
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('admin_save_vendor')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="name" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" required="" name="email">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Password</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" required="" name="password">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="contact">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="address">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Profile</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" accept="image/x-png,image/svg" name="profile">
                            <small> only png,svg icon allow</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                       
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">PAN Card</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" accept="image/x-png,image/svg" name="pancard">
                            <small> only png,svg icon allow</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                       
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Adhar Card</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" accept="image/x-png,image/svg" name="adharcard">
                            <small> only png,svg icon allow</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                       
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">GST Registration</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" accept="image/x-png,image/svg" name="gst">
                            <small> only png,svg icon allow</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                       
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Firm Registration</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" accept="image/x-png,image/svg" name="firm_registration">
                            <small> only png,svg icon allow</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                       
                      </div>
                    </div>
                    <input type="hidden" name="type" value="vendor">
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Save">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection