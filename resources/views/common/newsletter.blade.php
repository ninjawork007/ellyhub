  @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
     @if (\Session::has('failure'))
      <div class="alert alert-danger">
        <p>{{ \Session::get('failure') }}</p>
      </div><br />
     @endif
      <form method="post" action="{{url('newsletter')}}" class="mailchimp_form">
	  @csrf  
        
           <div class="input-group">
				<input type="text" class="form-control" name="email" placeholder="Your email address" required="required">
				<span class="input-group-btn">
				<button type="submit" class="btn btn-success btn-theme"><i class="fa fa-envelope" aria-hidden="true"></i></button>
				</span>
          </div>      
      </form>
