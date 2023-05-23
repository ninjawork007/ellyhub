<style>
.alert button.close {
    background: no-repeat;
    position: absolute;
    top: 0;
    right: 0;
}
</style>
@if (Session::has('danger'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h6><i class="icon fa fa-ban"></i> Error: {{ Session::get('danger') }}</h6>
</div>
@endif @if (Session::has('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h6><i class="icon fa fa-check"></i> Success: {{ Session::get('success') }}</h6>
</div>
@endif @if (Session::has('warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h6><i class="icon fa fa-warning"></i> Warning: {{ Session::get('warning') }}</h6>
</div>
@endif