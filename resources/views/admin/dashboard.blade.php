@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-5 mb-4 mb-xl-0">
                  <h4 class="font-weight-bold">Hi, Welcome Back!, {{Auth::user()->name}}!</h4>
                </div>
                @if(!Auth::user()->isactive)
                <div class="col-md-12 alert alert-primary" role="alert">
                  
                  <p class="font-weight-bold">Your account is under verification. Please upload your all details.</p>
                 
                </div>
                 @endif
                
              </div>
            </div>
          </div>
          <div class="row">

          <div class="col-md-6 col-lg-3">
              <div class="card">                
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-gold">
                        <i class="anticon anticon-shopping"></i>
                        </div>
                        <div class="m-l-15">
                            <h2 class="m-b-0">{{$orders}}</h2>
                            <p class="m-b-0">Orders</p>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-purple">
                              <i class="anticon anticon-hourglass"></i>
                      </div>
                      <div class="m-l-15">
                          <h2 class="m-b-0">{{$pending_order}}</h2>
                          <p class="m-b-0">Orders Pending!</p>
                      </div>
                  </div>                      
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-cyan">
                        <i class="anticon anticon-loading"></i>
                      </div>
                      <div class="m-l-15">
                          <h2 class="m-b-0">{{$processing_orders}}</h2>
                          <p class="m-b-0">Orders Procsessing!</p>
                      </div>
                  </div>                      
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                            <i class="anticon anticon-like"></i>
                      </div>
                      <div class="m-l-15">
                          <h2 class="m-b-0">{{$complete_orders}}</h2>
                          <p class="m-b-0">Orders Completed!</p>
                      </div>
                  </div>                      
                </div>
              </div>
            </div>	
            <div class="col-md-6 col-lg-3">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                      <div class="avatar avatar-icon avatar-lg avatar-cyan">
                          <i class="anticon anticon-dollar"></i>
                      </div>
                      <div class="m-l-15">
                          <h2 class="m-b-0"><span class="currency-symble">$</span>{{$earning}}</h2>
                          <p class="m-b-0">Total Earning</p>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                      <div class="avatar avatar-icon avatar-lg avatar-blue">
                      <i class="anticon anticon-appstore"></i>
                      </div>
                      <div class="m-l-15">
                          <h2 class="m-b-0">{{$product}}</h2>
                          <p class="m-b-0">Total Products</p>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            @if(Auth::user()->user_type=='superadmin')
            <div class="col-md-6 col-lg-3">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                      <div class="avatar avatar-icon avatar-lg avatar-gold">
                          <i class="anticon anticon-shop"></i>
                      </div>
                      <div class="m-l-15">
                          <h2 class="m-b-0">{{$vendor}}</h2>
                          <p class="m-b-0">Total Vendor</p>
                      </div>
                  </div>                  
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                      <div class="avatar avatar-icon avatar-lg avatar-purple">
                          <i class="anticon anticon-user"></i>
                      </div>
                      <div class="m-l-15">
                          <h2 class="m-b-0">{{$user}}</h2>
                          <p class="m-b-0">Total User</p>
                      </div>
                  </div>                      
                </div>
              </div>
            </div>
            @endif  		
          </div>
        </div>         
      </div>
@endsection