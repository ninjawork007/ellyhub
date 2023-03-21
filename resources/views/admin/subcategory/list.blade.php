@extends('layouts.admin')

@section('content')

<div class="main-panel">

        <div class="content-wrapper">

          <h4 class="card-title">Sub Category</h4>

          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">



              <div class="card">

                @include('alerts')

                <div class="card-body">

                  <div class="col-md-12">

                    <a href="{{route('add_sub_category')}}" class="btn btn-outline-secondary btn-fw text-right"><i class="fa fa-plus"></i></a>

                  </div>

                  <div class="table-responsive">



                    <table class="table table-hover">

                      <thead>

                        <tr>

                          <th>Name</th>

                          <th>Banner</th>

                          <th>Attributes</th>

                          <th>Date of created</th>

                          <th>Action</th>

                        </tr>

                      </thead>

                      <tbody>

                        @if(!$sub_category->isEmpty()) @foreach($sub_category as $key)

                        <tr id="{{$key->id}}">

                          <td>

                            &emsp;{{$key->title}}</td>

                            <td><?php if($key->banner){?><img src="{{url('public/'.$key->banner)}}" alt="image" style="width: 100px;border-radius: unset;" />

                          <?php }?></td>

                          <td><a href="{{route('attribute',['sub_category',$key->id])}}" class="btn btn-outline-primary btn-sm">Attribute</a></td>

                          <td>{{date('Y F, d',strtotime($key->created_at))}}</td>

                          <td>

                            <div>

                              <a href="{{route('edit_sub_category',[$key->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>

                              <a href="javascript:;" class="btn btn-danger btn-sm" onclick="delete_row('{{$key->id}}','sub_categories')"><i class="fa fa-trash"></i></a>

                            </div>

                          </td>

                        </tr>

                        @endforeach

                        @endif

                      </tbody>

                    </table>
{!! $sub_category->links() !!}
                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

       

      </div>

	   <script>

	  $( "body" ).addClass('sidebar-icon-only');

	  </script>

@endsection