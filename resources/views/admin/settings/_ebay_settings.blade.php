
    <div class="col-md-12">
        @if(!$ebay_auth)
            <label>Connect your eBay in ellyhub</label>
            <a class="btn btn-block btn-success" href="{{ route('showEbayLogin') }}">Sign In with eBay</a>
        @else
            <form action="{{ route('ebay_credentials_remove') }}" method="POST">    
                @csrf   
                @method('DELETE')
                <label>Disconnect your eBay in ellyhub</label>
                <button type="submit" class="btn btn-block btn-danger">Sign out on eBay</button>
            </form>  
        @endif
    </div>

    @if($ebay_auth)
    <div class="col-md-12 mt-4">
        <form method="POST" action="{{route('settings.update.paypal')}}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Paypal</label>
                    <input type="text" name="paypal" class="form-control" value="{{ $ebay_auth->paypal_email }}" required />
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-primary">Update Paypal</button>
        </form>
    </div>
    @endif

