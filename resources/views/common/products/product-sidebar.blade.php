<div class="search-filter">

    <!-- Category Search filter Start -->
    <div class="filter-box">
        <div class="filter-title">
            <h2>Product categories</h2>
        </div>
        <ul class="search-filter-list list-unstyled">
            @php $cat=1; 
                 $baseurl = url('/');
				
            @endphp
			@if(count($sub_categories) > 0)
            @foreach($sub_categories as $category)
                <li class="custom-checkbox">
                <input type="checkbox" name="cat[]" id="{{ $cat }}" class="sadia-checkbox" value="{{ $category->title }}" data-baseurl="{{ $baseurl }}">
                <label for="{{ $cat }}" class="sadia-checkbox-label">{{ $category->title }}</label>
            </li>
            @php $cat++; @endphp
            @endforeach
			@else
				<h3>Sorry, no category</h3>
            @endif
           
        </ul>
    </div>
    <!-- Category Search filter End -->

    <!-- Attribute Search filter Start -->
    <div class="filter-box">
			
		<?php 	
		
				$option_name =[];
				foreach($attributes_filter as $option){		
					 $option_name[] =  $option->AttrName;
				}
				$option_title = array_unique($option_name, SORT_REGULAR);
				
				foreach($option_title as $title){
					echo '<div class="filter-title">
							<h2>Filter by '.$title .'</h2>
						</div>';
					echo "<ul class='search-filter-list list-unstyled'>";
					$optionCount=1;
					foreach($attributes_filter as $option){
						if($title == $option->AttrName){							
							$result = str_replace(' ', '_', $title);
							echo '<li class="custom-checkbox">
							 <input type="checkbox" name="option[]" id="option_'. $optionCount.'" class="sadia-checkbox" value="'. $option->attrOption.'">
							<label for="option_'. $optionCount.'" class="sadia-checkbox-label">'. $option->attrOption.'</label></li>';
							}						
						 $optionCount++;
					}
					
				echo "</ul>";
				
				}
		?>
    </div> 
	<!-- Price Search filter Start -->
    <div class="filter-box">
        <div class="filter-title">
            <h2>Filter by price</h2>
        </div>
        <ul class="search-filter-list list-unstyled">
            <li class="custom-radio">
                <input type="radio" name="price" id="sixtentoeighteen" class="sadia-radio-input" value="0-300">
                <label for="sixtentoeighteen" class="sadia-radio-label"><span></span> £0.00 - £300.00 </label>
            </li>
            <li class="custom-radio">
                <input type="radio" name="price" id="twentyfivetothirtytwo" class="sadia-radio-input" value="300-600">
                <label for="twentyfivetothirtytwo" class="sadia-radio-label"><span></span> £300.00 - £600.00</label>
            </li>
            <li class="custom-radio">
                <input type="radio" name="price" id="fiftytofiftythree" class="sadia-radio-input" value="600-900">
                <label for="fiftytofiftythree" class="sadia-radio-label"><span></span> £600.00 - £900.00</label>
            </li>
        </ul>
    </div>
    <!-- Price Search filter End -->

        <!-- Recent Post Widget Start -->
        
        <div class="recent-post-widget filter-box">
        <div class="filter-title">
            <h2>Recent Products</h2>
        </div>
        @foreach($recent_products as $products)
        <div class="single-recent-post">
            <a href="#" class="single-post-thumb">
                <img src="{{ url('/public/images/product_images'). '/' .$products->image}}" alt="{{ $products->title }}">
            </a>
            <div class="single-post-content">
                <a href="#" class="single-post-title">{{ $products->title }}</a>
                <a href="#" class="single-post-date">{{ Carbon\Carbon::parse($products->created_at)->format('M d,Y') }}</a>
            </div>
        </div>
        @endforeach
    </div>
      
    <!-- Recent Post Widget End -->
</div>