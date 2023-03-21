@extends('layouts.admin')
@section('content')
<style type="text/css">
  .user-list {
    padding: 0px 10px 5px 10px;
}
div#email_div {
    max-height: 244px;
    min-height: 60px;
    overflow: scroll;
}
</style>
<div class="main-panel">
        <div class="content-wrapper">
          <h4 class="card-title">Send Mail</h4>
          <label class="amrcart-form__label amrcart-form__label-for-checkbox checkbox" for="checkAll">
            <input type="checkbox" id="checkAll" class="amrcart-form__input amrcart-form__input-checkbox input-checkbox" name="emails">
            <span>Check all</span>
          </label>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                @include('alerts')
                <div class="card-body">
                  <form class="form-sample" method="post" action="{{route('send_mail_touser')}}" data-parsley-validate="" id="form_sendmail">
                    <input type="hidden" name="ids" value="" id="comma_ids">
                    @csrf
                    
                    <div class="row">
                      <div class="col-md-6" id="email_div">
                        @if(!$user->isEmpty())
                        @foreach($user as $key)
                           <div class="user-list">
                            <label class="amrcart-form__label amrcart-form__label-for-checkbox checkbox" for="checkboxAgree{{$key->id}}">
                              <input type="checkbox" id="checkboxAgree{{$key->id}}" value="{{$key->id}}" class="amrcart-form__input amrcart-form__input-checkbox input-checkbox ckecbox-single" data-parsley-multiple="checkboxAgree{{$key->id}}" name="emails">
                            <span>{{$key->email}}
                            </span>
                            </label>
                          </div>
                        @endforeach 
                        @endif
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <textarea class="form-control" rows="15" placeholder="Write Message here..." required="" name="message"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row col-md-9">
                      <input type="button" class="btn btn-outline-primary btn-fw pull-right" id="submit_form" value="Submit">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $("#submit_form").click(function () {
          var id = $("input[name='emails']:checked").map(function () {  
              return this.value;
        }).get().join(",");
          if ($.trim(id)=='') {
            alert("Please select email.");return false;
          }
          $('#comma_ids').val(id);
          $('#form_sendmail').submit();
      });

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
      </script>
@endsection