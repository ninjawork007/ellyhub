@extends('layouts/master')
@section('content')

  <!-- breadcumb Start-->
		<div class="breadcumb-area text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 p-0">
							<div class="breadcumb-img">
								<img src="{{ asset('public/assets/images/breadcumb.jpg') }}" alt="about thumb">
							</div>
							<div class="breadcumb-list">
								<ul class="list-inline">
									<li class="list-inline-item"><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right" aria-hidden="true"></i></li>
									@for($i = 0; $i <= count(Request::segments()); $i++)
									<li class="list-inline-item">
									  <a href="">{{Request::segment($i)}}</a>
									  @if($i < count(Request::segments()) & $i > 0)
										{!!'<i class="fa fa-angle-right"></i>'!!}
									  @endif
									  </li>
									@endfor
								</ul>
							</div>
                        </div>
                    </div>
                </div>
            </div>
  <!-- breadcumb End-->
   <div class="BC009 middle_column deckingBuilderDesktop">	
	<div class="middle_column_padding">
		@if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
      <div id="decking-calc" class="shape-Square">
      <p class="title">Decking <span class="paleBlue">Calculator</span></p>
      <p>Use our Decking Calculator to help you get all the pieces you need to create your garden decking to whatever size you need.</p>
      <p id="working" class="working" style="opacity: 0; display: none;">

      Please wait whilst the Decking Calculator<br> downloads the latest products and prices. <br><br>
      <img src="/images/decking_calc/shd/loading.gif" alt="working...">
      </p>
      </div>     
    <!---- first part start---------->
 
	<div class="builder-panel" id="panel-deck-shape" style="display: block;">
      <button class="next box_shape"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
      <p class="question">What shape decking do you require?</p>
      <ul class="menu">
        <?php $baseurl = url('/'); ?>
        
        <li class="active">
        <img src="{{ asset('public/assets/images/square1.png') }}" alt="Square">
        <a class="button button_shape" id="deck-shape-square" data-shape="Square" data-url="{{ $baseurl }}">
         <i class="fa fa-check-square" aria-hidden="true"></i> <span>Square</span>
        </a>
        </li>
        <li>
        <img src="{{ asset('public/assets/images/rectangle.png') }}" alt="Rectangle">
        <a class="button button_shape" id="deck-shape-rectangle" data-shape="Rectangle" data-url="{{ $baseurl }}">
        <i class="fa fa-check-square" aria-hidden="true"></i>  <span>Rectangle</span>
        </a>
        </li>
      </ul>      
      <p class="noticeMsg">For other shapes please call our sales department<br>for advice on on <span class="dynPhoneNumber">0208 6178979</span> or email sales@buildersmerchant.com</p>        
	   <button class="next box_shape" id="ajax_shape"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
    </div>
    <!---- first part end---------->
    <!---- second part start---------->
    <div class="builder-panel" id="panel-deck-shape-measurements">
		<button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
		<button class="next box_measure"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
        <p class="question">Configure your shape</p>
        <p class="detail">Please give us the measurements, in millimetres, of the size you would like your decking to be. Please note, 1m is the equivalent to 1000mm:</p>
        <div class="shape"></div>
        <ul class="deckShape">
          <li id="meas1"><label>A:</label><input id="measurement1" min="500" value="2500" type="number" name="measurement1" class="on" data-url="{{ $baseurl }}"> mm</li> <span>A is larger size</span>
          <li id="meas2"><label>B:</label><input id="measurement2" min="500" value="2500" type="number" name="measurement2" class="on" data-url="{{ $baseurl }}"> mm</li>
        </ul>
		<div id="total_measure">
	    <div><label>=</label><input type="text" name="total_measure" value="6.25"> mm<sup>2</sup></div>
		</div>
        <p class="usseful"><strong>Useful Conversions</strong></p>
        <table id="conversion-table" align="center">
	    <tbody>
		  <tr>
            <td>0.5m = 500mm</td>
            <td>1.0m = 1000mm</td>
          </tr>
          <tr>
            <td>50 inches = 1000mm</td>
            <td>100 inches = 2540mm</td>
          </tr> 
          <tr>
            <td>12ft  = 1270mm</td>
            <td>6ft = 1828mm</td>
          </tr>
          <tr>
            <td>1.5m = 1500mm</td>
            <td>3.0m = 3000mm</td>
          </tr>
        </tbody>
		</table>
		<button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
		<button class="next box_measure"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
    </div> 
	<!---- second part end---------->
	
	<!---- third part end---------->
	<div class="builder-panel">   
	<button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
    <button class="next"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
		<div class="board-direction">
          <p class="question">Which direction should your boards run?</p>
          <div class="shape"></div>
          <ol class="boardMeasurements" id="boardMeasurements">
            <li class="mmA">2500</li>
            <li class="mmB">2500</li>
            <li class="mmC">1000</li>
            <li class="mmD">1000</li>
          </ol>
		<p class="noticeMsg">Boards should always run the opposite way to the natural direction of traffic.</p>
		<div class="builder-panel1" id="panel-deck-shape" >
			<p class="question">What shape decking do you require?</p>
			<ul class="menu side_packs">			  
			  
			  <li class="active">
				<img class="front-image" src="{{ asset('public/assets/images/fronttoback.png') }}" alt="Square">
				<a class="button on" data-side="Front to Back">
					<i class="fa fa-check-square" aria-hidden="true"></i>
				  <span>Front to Back</span>
				</a>
			  </li>
			  <li>
				<img class="front-image" src="{{ asset('public/assets/images/lefttoright.png') }}" alt="Rectangle">
				<a class="button" data-side="Left to Right">
					<i class="fa fa-check-square" aria-hidden="true"></i>
				  <span>Left to Right</span>
				</a>
			  </li>
			</ul>
          
		</div>
        </div>
    <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
    <button class="next"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
	</div> 
	<!---- 4 part start---------->
   <div class="builder-panel">
	<button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
    <button class="next decking_length"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
        <div class="builder-panel" id="panel-deck-board-type" >
        <p class="question">We have two types of boards available, either standard, or heavy duty (best used for decking that will have heavy usage)</p>
        <p class="detail">Please select which board you need:</p>  
  
		</div>    
	<div class="board-direction">
		<div class="builder-panel1" id="panel-deck-shape">      
        <ul class="menu decking_li">          
          <li class="active">
            <a class="button" id="deck-Composite-Decking" data-decking="Composite Decking">
              <img src="">
              <span>Composite Decking</span>
            </a>
              <span class="noticeMsg"><p>Composite Decking is a combination of plastic and wood to give a beautiful modern finish wood grain and groove options- 150 x 23 mm</p></span>
          </li>
          <li>
            <a class="button" id="deck-shape-Decking" data-decking="Treated Wood Decking">
              <img src="">
              <span>Treated Wood Decking</span>
            </a>
		   <span class="noticeMsg"><p>Kiln Dried Pressure Green treated Planed from 150 x 32 mm gives actual size of approx 140 x 28mm</p></span>
          </li>
        </ul>          
		</div>
	</div>
    <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
    <button class="next decking_length"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
	</div>
    <!---- 4 part end---------->
	<!---- 5 part start---------->
      
	<div class="builder-panel">   
    <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
    <button class="next number_packs"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
            <img src="{{ asset('public/assets/images/flatground.png') }}">
            <p class="detail">Please select a length:</p>     
		<div class="board-direction">
		<div class="builder-panel1" id="panel-deck-shape" >
        <ul class="menu six-mm" id ="decking_lentgh">          
          <li class="active">
            <a class="button on" data-slop="1.45M">
              <span>1.45M</span> 
			</a>          
          </li>
		  <li>
            <a class="button" data-slop="1.8M">
              <span>1.8M</span> 
			</a>          
          </li>
		  <li>
            <a class="button" data-slop="2.9M">
              <span>2.9M</span> 
			</a>          
          </li>
		  <li>
            <a class="button" data-slop="3.6M">
              <span>3.6M</span> 
			</a>          
          </li>
        </ul>
		<ul class="menu six-mm" id ="composite_length">          
          <li class="active">
            <a class="button on" data-slop="1.2M">
              <span>1.2M</span> 
			</a>          
          </li>
		  <li>
            <a class="button" data-slop="2.4M">
              <span>2.4M</span> 
			</a>          
          </li>
		  <li>
            <a class="button" data-slop="3.6M">
              <span>3.6M</span> 
			</a>          
          </li>
		  <li>
            <a class="button" data-slop="4.8M">
              <span>4.8M</span> 
			</a>          
          </li>
        </ul>
		</div>
        </div>
    <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
    <button class="next number_packs"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
	</div>
    <!---- 5 part end---------->
	<!---- 6 part start---------->
      
	<div class="builder-panel" id="panel-deck-fascias" >
     <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
     <button class="next decking_order"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
        <div class="fascia-detail">
		 <p class="title">Decking <span class="paleBlue">Calculator</span></p>
		 <p class="uses">Use our Decking Calculator to help you get all the pieces you need to create your garden decking to whatever size you need.</p>
         <p class="question">Choose your extras</p>
            <span class="noticeMsg">We've calculated how many packs of <strong>screws and nails</strong>, <strong>bags of postcrete</strong> and how much <strong>weed suppressant membrane</strong> we think you will need and filled in the boxes below based on our calculations...</span>
        <ul class="extrasList" id="extrasList">          
        
        </ul> 
		</div>
	 <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
     <button class="next decking_order"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Continue</button>
	</div>            
       <!---- 6 part end---------->
       
	<div class="builder-panel" id="panel-summary" >
     <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
        <div class="fascia-detail">
         <p class="question">Order Summary</p>
		 <div id="order_details"></div>
            
            <div class="sum-direction important">
            	<?php $prod_id = "17,19,20,21"; ?>
            <p class="sumMsg">Important information below, please read and <a href="javascript:window.print();">print</a>.</p>
            <p><img id="imgWorking" class="imgWorking" src="/-/media/images/Decking Builder/shd/working-small.gif" alt="Working..." style="display: none;"><a class="mainBtn" data-id="<?php echo $prod_id; ?>" id="deckingCalcAddToBasket">Add to basket</a></p>
            <p class="sumInfohelp"><a href="#panel-deck-shape" class="changeOpt sumHelp">Start again</a> Need help? 0800 408 2234</p>
                        <div id="cart_msg"></div>

          </div>

            <div class="installInstr">
            <p class="install" id="">Installing your new Deck</p>
            <p>We have calculated your deck based on the following installation guidelines:</p>
          
            <p class="installDetails">Laying your joists</p>
            <p>When laying your joists please start at row 1 by laying one complete joist at a right angle to the direction that your boards are going to run. Continue to lay joists end on end until you have exceeded the width of your deck. Cut off any excess joist and then start row 2 with the resulting off cut. Please see the diagram below for a visual representation of this.</p>
            <p><strong>Diagram to show how the offcut from row 1 should be used to start row 2.</strong></p>
            <p>Example shown based on a 5000mm (5m) wide deck.</p>
            <img src="{{ asset('public/assets/images/diagram-joists.png') }}">
            <p class="installDetails">Fascias</p>
            <p>All our fascias are standard decking boards. Should you wish to add a fascia we have calculated that you will need <strong><span id="fasciaPanelsNeeded">2</span></strong> of these to finish off your deck.</p>
          </div>
  
  </div>
    <button class="back"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Back</button>
  </div>
  </div> 
       
        </div>

@endsection