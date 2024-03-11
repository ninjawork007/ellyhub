@if (Session::has('danger'))
<div class="alert alert-danger  mt-2 alert-dismissible">
    <h6 class="mb-0"><i class="icon fa fa-ban"></i> Error: {{ Session::get('danger') }}</h6>
</div>
@endif @if (Session::has('success'))
<div class="alert alert-success  mt-2 alert-dismissible">
    <h6 class="mb-0"><i class="icon fa fa-check"></i> Success: {{ Session::get('success') }}</h6>
</div>
@endif @if (Session::has('warning'))
<div class="alert alert-warning  mt-2 alert-dismissible">
    <h6 class="mb-0"><i class="icon fa fa-warning"></i> Warning: {{ Session::get('warning') }}</h6>
</div>
@endif
@if (Session::has('info'))
<div class="alert alert-info  mt-2 alert-dismissible">
    <h6 class="mb-0"><i class="icon fa fa-warning"></i> Warning: {{ Session::get('info') }}</h6>
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif