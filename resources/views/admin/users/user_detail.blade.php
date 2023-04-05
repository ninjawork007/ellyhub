@extends('layouts.admin')
@section('content')
<style type="text/css">
  td select.form-control {
    width: 100px;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Vendors Detail</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                @include('alerts')
                <div class="error"></div>
                <div class="card-body">
                  <div class="col-md-12">
                    <!-- <a href="{{route('add_product')}}" class="btn btn-outline-secondary btn-fw float-right"><i class="fa fa-plus"></i></a> -->
                  </div>
                  <div class="table-responsive">

                    <table class="table table-hover" id="myTable">
                      <tbody>
                        <tr>
                          <th data-orderable="false">Name</th>
                          <td data-orderable="false">{{$vendor->name}}</td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Email</th>
                          <td data-orderable="false">{{$vendor->email}} <span class="{{($vendor->email_verify=='yes')?'text-success':'text-danger'}}">{{($vendor->email_verify=='yes')?'verified':'unverified'}}</span></td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Mobile</th>
                          <td data-orderable="false">{{$vendor->mobile}}</td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Balance</th>
                          <td data-orderable="false">{{$vendor->balance}}</td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Profile</th>
                          <td data-orderable="false">
                            @if($vendor->image)
                            <img src="{{url('public/'.$vendor->image)}}">
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>

                        <tr>
                          <th data-orderable="false">Complete Address</th>
                          <td>{{@$vendor_information->complete_address}}
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Pan Card</th>
                          <td>
                            @if(@$vendor_information->pan_card)
                            <img src="{{@url('public/'.$vendor_information->pan_card)}}">
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Adhar Card</th>
                          <td>
                            @if(@$vendor_information->adhar_card)
                            <img src="{{@url('public/'.$vendor_information->adhar_card)}}">
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">GST Registration</th>
                          <td>
                            @if(@$vendor_information->gst_registration)
                            <img src="{{@url('public/'.$vendor_information->gst_registration)}}">
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Firm Registration</th>
                          <td>
                            @if(@$vendor_information->firm_registration)
                            <img src="{{@url('public/'.$vendor_information->firm_registration)}}">
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Bank Name</th>
                          <td>
                            @if(@$bank_detail->bank_name)
                            {{@$bank_detail->bank_name}}
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Account Number</th>
                          <td>
                            @if(@$bank_detail->account_number)
                            {{@$bank_detail->account_number}}
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">IFSC</th>
                          <td>
                            @if(@$bank_detail->ifsc)
                            {{@$bank_detail->ifsc}}
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                        <tr>
                          <th data-orderable="false">Account holder Name</th>
                          <td>
                            @if(@$bank_detail->accountant_name)
                            {{@$bank_detail->accountant_name}}
                            @else
                            Not updated
                            @endif
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection