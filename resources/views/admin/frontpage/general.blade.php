@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">General Setting</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                @include('alerts')
                <div class="card-body">
                  <div class="row m-b-30">
                    <div class="col-lg-8">
                      <h3>Settings</h3>
                    </div>
                    <div class="col-lg-4 text-right">
                    </div>  
                  </div>
                  <form class="form-sample" method="post" action="{{route('update_settings')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                     <div class="row">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Site Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""   value="{{$data->site_title}}" name="site_title" >
                          </div>
                        </div>
 
             <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  value="{{$data->phone}}" name="phone">
                          </div>
                        </div>
            
            <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Whatsapp Number<small>(With Country Code)</small></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  value="{{$data->whatsapp}}" name="whatsapp">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Whatsapp Message</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  value="{{$data->whatsapp_message}}" name="whatsapp_message">
                          </div>
                        </div>

            
            <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""   value="{{$data->email}}"  name="email">
                          </div>
                        </div>
            
            <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""   value="{{$data->address}}"  name="address">
                          </div>
                        </div>
            
            <div class="form-group row">
                          <label class="col-sm-3 col-form-label">City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  value="{{$data->city}}" name="city">
                          </div>
                        </div>
            
            <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  value="{{$data->state}}" name="state">
                          </div>
                        </div>
            
            
            <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""    value="{{$data->country}}" name="country">
                          </div>
                        </div>
            
            <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country Code</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  value="{{$data->country_code}}"  name="country_code">
                          </div>
                        </div>
            
                       <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Currency Sign</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required=""  value="{{$data->currency_sign}}" name="currency_sign">
                          </div>
                        </div>
            
                      </div>
 
            
                    </div>

           
          
          <div class="row"> 
             <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> logo</label>
                          <div class="col-sm-3">
                            <input class="form-control" type="file" onchange="readURL(this);"   accept="image/x-jpg,image/jpeg,image/png" name="logo">
                            <small> only JPG, JPEG , PNG images are allowed</small>
              </div>
              <div class="col-sm-3">
                           <?php if($data->logo){?>
                    <img src="{{url($data->logo)}}"  id="show_img"   />
               <?php } else{?>
                   <img src="{{url('no-image.png')}}"  id="show_img" class="edit_img" />
               <?php  }  ?>
                          </div>
                        </div>
                      </div>
                     </div>


          <div class="row"> 
             <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Footer logo</label>
                          <div class="col-sm-3">
                            <input class="form-control" type="file" onchange="readURL2(this);"   accept="image/x-jpg,image/jpeg,image/png" name="footer_logo">
                            <small> only JPG, JPEG , PNG images are allowed</small>
                            </div>
                            <div class="col-sm-3">
                                         <?php if($data->footer_logo){?>
                                  <img src="{{url($data->footer_logo)}}"  id="show_img2"   />
                             <?php } else{?>
                                 <img src="{{url('no-image.png')}}"  id="show_img2" class="edit_img" />
                             <?php  }  ?>
                          </div>
                        </div>
                      </div>
                     </div>


           
           <div class="row"> 
             <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label"> Icon</label>
                          <div class="col-sm-3">
                            <input class="form-control" type="file" onchange="readURL1(this);"   accept="image/x-jpg,image/jpeg,image/png" name="icon">
                            <small> only JPG, JPEG , PNG images are allowed</small>
              </div>
                          <div class="col-sm-3">
                                       <?php if($data->icon){?>
                                <img src="{{url($data->icon)}}"  id="show_img1"  />
                           <?php } else{?>
                               <img src="{{url('no-image.png')}}"  id="show_img1" class="edit_img" />
                           <?php  }  ?>
                          </div>
                        </div>
                      </div>
                     </div>
           
           
 
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-success form-control  btn-fw pull-right" value="Update">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>


@endsection