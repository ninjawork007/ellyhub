@extends('layouts.admin')
@section('content')

<style>
img.image_ {
    width: 100px;
    height: 100px;
    border: 1px solid;
    padding: 10px;
    margin: 8px;
    cursor: pointer;
}
</style>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                @if(!Auth::user()->isactive)
                <div class="col-md-12 alert alert-primary" role="alert"">
                  
                  <p class="font-weight-bold">Your account is under verification. Please upload your all details.</p>
                  
                </div>
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  @if(!Auth::user()->isactive)
                   <p class="text-center">Note:- Please update details correctly. admin will verify your account by checking your details.</p>
                   @endif
                  <form class="form-sample" method="post" action="{{route('update_vendor_information')}}" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
					  <div class="col-md-12 text-center profile-pic">
                        @if(@$user_info->profile_photo)
                        <img src="{{@url('public/'.$user_info->profile_photo)}}" class="image_">
                        @else
                        <img src="{{url('public/no-image.png')}}" class="image_">
                        @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="name" value="{{Auth::user()->name}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" required="" readonly="" value="{{Auth::user()->email}}">
                            <small>To change email contact to admin.</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Mobile</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" id="title" name="mobile" value="{{Auth::user()->mobile}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="address" value="{{@$user_info->complete_address}}" id="type_address" placeholder="type your address">
                          </div>
                        </div>
                        <?php
                        $address_array = @json_decode($user_info->address_json);
                        if (json_last_error()==0) {
                          $address = true;
                        }else{
                          $address = false;
                        }
                        // print_r($address_array);
                        ?>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="city" value="<?php if($address){ echo $address_array->city;}?>" id="city" placeholder="City">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="state" value="<?php if($address){ echo $address_array->state;}?>" id="state" placeholder="State">
                            <input type="hidden" name="state_short" value="<?php if($address){ echo $address_array->state_short;}?>" id="state_short">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="country_long" value="<?php if($address){ echo $address_array->country_long;}?>" id="country_long" placeholder="Country">
                            <input type="hidden" name="country_short" id="country_short" value="<?php if($address){ echo $address_array->country_short;}?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Zip Code</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="zipcode" value="<?php if($address){ echo $address_array->zipcode;}?>" id="zipcode" placeholder="Zip Code">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Profile</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" name="profile">
                          </div>
                        </div>
                      </div>
                      </div>
                       <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">PAN Card</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" name="pancard">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 ">
                        
						 @if(@$user_info->pan_card)
                        <img src="{{@url('public/'.$user_info->pan_card)}}" class="image_">
                        @else
                        <img src="{{url('public/no-image.png')}}" class="image_">
                        @endif
						
                      </div>
                      </div>
                       <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Adhar Card</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" name="adharcard">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
						@if(@$user_info->adhar_card)
                        <img src="{{@url('public/'.$user_info->adhar_card)}}" class="image_">
                        @else
                        <img src="{{url('public/no-image.png')}}" class="image_">
                        @endif
                      </div>
                      </div>
                       <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">GST Registration</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" name="gst">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        
						@if(@$user_info->gst_registration)
                        <img src="{{@url('public/'.$user_info->gst_registration)}}" class="image_">
                        @else
                        <img src="{{url('public/no-image.png')}}" class="image_">
                        @endif
                      </div>
                      </div>
                       <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Firm Registration</label>
                          <div class="col-sm-9">
                            <input type="file" class="form-control" name="firm_registration">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
						@if(@$user_info->firm_registration)
                        <img src="{{@url('public/'.$user_info->firm_registration)}}" class="image_">
                        @else
                        <img src="{{url('public/no-image.png')}}" class="image_">
                        @endif
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
           <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  @if(!Auth::user()->isactive)
                   <p class="text-center">Note:- Please update details correctly. admin will verify your account by checking your details.</p>
                   @endif
                  <form class="form-sample" method="post" action="{{route('update_bank_information')}}" data-parsley-validate="">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Bank Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="bank_name" value="{{@$bank->bank_name}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Account Number</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="account_number" value="{{@$bank->account_number}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Bank IFSC</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="ifsc" value="{{@$bank->ifsc}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Account Holder Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required="" name="accountant_name" value="{{@$bank->accountant_name}}">
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBv3FYZuLZJR8mOlONc6hMGqh-Taeo7-7g&libraries=places"></script>
<script type="text/javascript">
 function initialize() {
        var input = document.getElementById('type_address');
        var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.setComponentRestrictions({'country': ['us']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
             var place = autocomplete.getPlace();
       var lat = place.geometry.location.lat();
       var log = place.geometry.location.lng();
       console.log(lat);
       console.log(log);
             curent_address(lat,log);    
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize); 
  
  
  
function curent_address(lat,log) {
 
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, log);
 
    geocoder.geocode({'latLng': latlng}, 
  
  function (results, status) {
    console.log(results);
            if (status == google.maps.GeocoderStatus.OK) {
                for (var i = 0; i < results[0].address_components.length; i++) {
                for (var j = 0; j < results[0].address_components[i].types.length; j++) {
        
                  // document.getElementById('city').value = '';
                  if (results[0].address_components[i].types[j] == "postal_code") {
                    $('#zipcode').val(results[0].address_components[i].long_name);
                     
                  }
                  if (results[0].address_components[i].types[j] == "country") {
                    document.getElementById('country_short').value = results[0].address_components[i].short_name;
                    document.getElementById('country_long').value = results[0].address_components[i].long_name;
                  }
                  if (results[0].address_components[i].types[j]=="administrative_area_level_1") {
                     document.getElementById('state').value = results[0].address_components[i].long_name;
                     document.getElementById('state_short').value = results[0].address_components[i].short_name;
                  }
                  if (results[0].address_components[i].types[j]=="administrative_area_level_2") {

                     document.getElementById('city').value = results[0].address_components[i].long_name;
                  }
        
         }
       }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });
}



   </script>
@endsection