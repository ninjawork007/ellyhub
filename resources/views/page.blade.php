@extends('layouts.web')

@section('content')
<main class="no-main">
        <nav class="amrcart-breadcrumb">
    <a href="{{url('/')}}">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
        
    </span>
   {{$page->type}}
</nav>
        <section class="section--contact">
            <div class="container">
                <h2 class="page__title text-center">{{$page->type}}</h2>
                <div class="contact__content">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $page->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>		
@endsection

