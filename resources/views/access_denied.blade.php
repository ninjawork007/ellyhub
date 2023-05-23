@extends('layouts.web')

@section('content')
<main class="no-main">
        <section class="section--notfound">
            <div class="container">
                <div class="notfound__content">
                    <h1 class="page__title">Oop! Access Denied!!!</h1>
                    <p>You can't access this page. Go back <span><a href="{{url('/')}}">Home</a></span></p>
                </div>
            </div>
        </section>
    </main>
@endsection

