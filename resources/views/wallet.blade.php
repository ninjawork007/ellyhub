@extends('layouts.web')



@section('content')

  <nav class="amrcart-breadcrumb">
    <a href="https://bazarhat99.com">Home</a>
    <span class="delimiter">
        <i class="icon amr-breadcrumbs-arrow-right"></i>
    </span> Wallet
</nav>
 <div class="wallet">
       <div  class="content-area">
<main id="main" class="site-main">
    <section class="section--wallet">

            <div class="container">

                <h2 class="page__title">Balance :- ₹{{Auth::user()->balance}}</h2>

                <div class="wishlist__content">

                    <div class="wishlist__product">

                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</div>
<script type="text/javascript">
</script>

@endsection



