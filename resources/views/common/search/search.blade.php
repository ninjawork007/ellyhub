<form action="{{ route("product.search") }}" method="POST" enctype="multipart/form-data">
	<div class="input-group">	
	    @csrf
		<input type="hidden" name="search_param" value="all" id="search_param">         
		<input type="text" class="form-control" name="keyword" placeholder="Search term...">
		<span class="input-group-btn searchbtn">
			<input class="btn btn-default" value="Search" type="submit">
		</span>	
	</div>
</form>