@extends('layouts.admin')

@section('content')

<div class="main-panel">

        <div class="content-wrapper">

          <h4 class="card-title">Connect to eBay</h4>

          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">



              <div class="card">

                @include('alerts')

				<div class="error"></div>

                <div class="card-body">

                  <div class="col-md-12">

                   

                  </div>
                 
                       <div class="table-responsive">
                      
                           
                                @include('admin/settings._ebay_settings')
                                </div>
                           
                         
                      
                       
                

    </div>

              </div>

            </div>

          </div>

        </div>

       

      </div>
@endsection