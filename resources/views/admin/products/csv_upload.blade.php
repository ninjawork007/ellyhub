@extends('layouts.admin')

@section('content')

<style type="text/css">
.form-control.readonly {
    background-color: #eaeaea;
    pointer-events: none;
}
hr {
    border-top: 1px solid #eaeaea;
}
input[type="checkbox"] {
    zoom: 2;
    margin-left: -4px;
}
.nav-pills.nav-pills-vertical {
    flex-direction: unset !important;
}
p.category_show.text-center {
    font-size: 20px;
    padding: 10px 0px 1px 0px;
}
p.brand_show.text-center {
    font-size: 20px;
    padding: 10px 0px 1px 0px;
}
</style>

<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">CSV Upload</h4>
          <div class="alert alert-warning text-dark" role="alert"><strong>For Sample csv download from <a href="{{asset('storage/bazarhat99_csv_examples.csv')}}">here</a></strong></div>
		  
      <div class="row">
        <div class="col-md-6 col-xl-6 grid-margin stretch-card d-none d-md-flex">
          <div class="card">
            <div class="card-body">
              <hr>
              <select class="form-control category">
                <option value="">Select category</option>
                @if(count($category))
                @foreach($category as $key)
                <option value="{{$key->id}}">{{$key->name}}</option>
                @endforeach
                @endif
              </select>
              <p class="category_show text-center"></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-6 grid-margin stretch-card d-none d-md-flex">
          <div class="card">
            <div class="card-body">
              <hr>
              <select class="form-control brand">
                <option value="">Select Brand</option>
                @if(count($brand))
                @foreach($brand as $key)
                <option value="{{$key->id}}">{{$key->title}}</option>
                @endforeach
                @endif
              </select>
              <p class="brand_show text-center"></p>
            </div>
          </div>
        </div>
      </div>
          <div class="row">
            <div class="col-md-12 col-xl-12 grid-margin stretch-card d-none d-md-flex">
              <div class="card">
                <div class="card-body">
                  <hr>
				   <form class="form-sample" method="post" action="{{route('save_csv')}}" data-parsley-validate="" enctype="multipart/form-data">
                     @csrf
					<div class="row col-md-12">
						<div class="row col-md-3">
		                    <label class="">Upload CSV</label>
		                </div>
	                    <div class="form-group col-md-9">
	                     	<input type="file" name="csv" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
	                    </div>
                    </div>
                    <div class="row col-md-12">
                      <input type="submit" class="btn btn-outline-primary btn-fw pull-right" value="Save" >
                    </div>
					 </div>
                    </div>
                  </div>
				   </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $('.category').change(function(){
          $('.category_show').html($(this).val());
        });
        $('.brand').change(function(){
          $('.brand_show').html($(this).val());
        });
      </script>
@endsection