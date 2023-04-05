@extends('layouts.admin')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">membership</h4>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">

              <div class="card">
                @include('alerts')
                <div class="card-body">
                  <div class="col-md-12">
                    <a href="{{route('add_membership')}}" class="btn btn-outline-secondary btn-fw "><i class="fa fa-plus"></i></a>
                  </div>
                  <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Price</th>
                          <th>Date of created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(!$list->isEmpty()) @foreach($list as $key)
                        <tr id="{{$key->id}}">
                          <td>{{$key->title}}</td>
                          <td>${{$key->price}}</td>
                          <td>{{date('Y F, d',strtotime($key->created_at))}}</td>
                          <td>
                            <div>
                              <a href="{{route('edit_membership',[$key->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                              <a href="javascript:;" class="btn btn-danger btn-sm" onclick="delete_row('{{$key->id}}','memberships')"><i class="fa fa-trash"></i></a>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{date('Y')}} <a href="javascript:;" target="_blank">openinvite</a>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
@endsection