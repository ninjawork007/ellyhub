@extends('layouts.web')
@section('content')
<!--title-bar start-->
	<section class="title-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="left-title-text">
					<h3>My Account</h3>
					</div>
				</div>
				<div class="col-md-6">
					<div class="right-title-text">  
						<ul>
							<li class="breadcrumb-item"><a href="index.html">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">My Account</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--title-bar end-->	
	<!--my-account start-->
	<section class="my-account">			
		<div class="profile-bg">
			<img src="{{url('public/assets/images/profile/bg-img.jpg')}}" alt="Responsive image">
			<div class="my-Profile-dt">
				<div class="container">
					<div class="row">
						<div class="container">							
							<div class="profile-dpt">
								<img src="{{url('public/assets/images/profile/dp-1.jpg')}}" alt="">
							</div>
							<div class="profile-all-dt">
								<div class="profile-name-dt">
									<h1>John Doe</h1>
									<p><span><i class="fas fa-map-marker-alt"></i></span>Sydney, Australia</p>
								</div>
								<div class="profile-dt">
									<!-- <ul>										
										<li> 
											<a href="#" class="setting-btn btn-link"><span><i class="fas fa-cog"></i></span>Setting</a>
										</li>
									</ul> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--my-account end-->	
	<!--my-account-tabs start-->
	<section class="all-profile-details">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-12">
					<div class="left-tab-links">
						<div class="nav nav-pills nav-stacked nav-tabs ui vertical menu fluid">
							<!-- <a href="#timeline"  data-toggle="tab" class="item user-tab cursor-pointer active">Timeline</a> -->
							<a href="#about" data-toggle="tab" class="item user-tab cursor-pointer">About</a>
							<a href="#photos" data-toggle="tab" class="item user-tab cursor-pointer" id="bookmarks" data-tab="bookmarks">Photos</a>																
							<a href="#following" data-toggle="tab" class="item user-tab cursor-pointer">Following</a>
							 <!-- <a href="#" data-toggle="tab" class="item user-tab cursor-pointer">Rating</a> -->
							<!--<a href="#" data-toggle="tab" class="item user-tab cursor-pointer">Order History</a> -->	
						</div>						
					</div>				
				</div>
				<div class="col-lg-9 col-md-8 col-12">
					<div class="tab-content">
						<div class="tab-pane" id="following">
							<div class="timeline">
								<div class="tab-content-heading">
									<h4>Followings</h4>						
								</div>
								<div class="about-dtp">
									<div class="follow-bg">
										<ul>
											<li>
												<div class="suggestion-usd-2">
													<a href="#"><img src="{{url('public/assets/images/profile/noti-1.png')}}" alt=""></a>
													<div class="sgt-text-2">
														<a href="#"><h4>Jassica William</h4></a>
														<p><span><i class="fas fa-map-marker-alt"></i></span> Sydney, Australia<p>
													</div>
													<button class="btn-link">Following</button>
												</div>
											</li>
											<li>
												<div class="suggestion-usd-2">
													<a href="#"><img src="{{url('public/assets/images/profile/noti-2.')}}'" alt=""></a>
													<div class="sgt-text-2">
														<a href="#"><h4>Johnson Smith</h4></a>
														<p><span><i class="fas fa-map-marker-alt"></i></span> Sydney, Australia<p>
													</div>
													<button class="btn-link">Following</button>
												</div>
											</li>
											<li>
												<div class="suggestion-usd-2">
													<a href="#"><img src="{{url('public/assets/images/profile/noti-1.png')}}" alt=""></a>
													<div class="sgt-text-2">
														<a href="#"><h4>Jassica William</h4></a>
														<p><span><i class="fas fa-map-marker-alt"></i></span> Sydney, Australia<p>
													</div>
													<button class="btn-link">Following</button>
												</div>
											</li>
											<li>
												<div class="suggestion-usd-2">
													<a href="#"><img src="{{url('public/assets/images/profile/noti-2.')}}'" alt=""></a>
													<div class="sgt-text-2">
														<a href="#"><h4>Johnson Smith</h4></a>
														<p><span><i class="fas fa-map-marker-alt"></i></span> Sydney, Australia<p>
													</div>
													<button class="btn-link">Following</button>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane active" id="about">
							<div class="profile-about">
								<div class="tab-content-heading">
									<h4>About</h4>
									<!-- <a href="setting.html"><i class="far fa-edit"></i>Edit Info</a> -->
								</div>
								<div class="about-dtp">
									<div class="about-bg">
										<ul>
											<li>
												<div class="dp-detail">
													<h6>Ful Name</h6>
													<p>John Doe</p>
												</div>
											</li>
											<li>
												<div class="dp-detail">
													<h6>Location</h6>
													<p>Hill District, Sydney, Australia</p>
												</div>
											</li>
											<li>
												<div class="dp-detail">
													<h6>Mobile Number</h6>
													<p>+ 2 987 654 3210</p>
												</div>
											</li>
											<li>
												<div class="dp-detail">
													<h6>Email Address</h6>
													<p>Johndoe@gmail.com</p>
												</div>
											</li>
											<li>
												<div class="dp-detail">
													<h6>Personal Website</h6>
													<p>www.johndoe.com</p>
												</div>
											</li>
											<li>
												<div class="dp-detail">
													<h6>Description About Yopur Self</h6>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum leo sit amet volutpat porta. Integer tincidunt id enim eget suscipit. Aenean vitae mi at arcu pulvinar dictum. Donec pretium ipsum diam, vitae posuere nunc dapibus ut. Vivamus tempus et magna at elementum</p>
												</div>
											</li>
											<li>
												<div class="dp-detail">
													<h6>Social Accounts</h6>
													<div class="my-social-links">
														<a href="#" class="socail-btn-link f-btn"><i class="fab fa-facebook-f"></i></a>
														<a href="#" class="socail-btn-link t-btn"><i class="fab fa-twitter"></i></a>
														<a href="#" class="socail-btn-link g-btn"><i class="fab fa-google"></i></a>
														<a href="#" class="socail-btn-link i-btn"><i class="fab fa-instagram"></i></a>
														<a href="#" class="socail-btn-link y-btn"><i class="fab fa-youtube"></i></a>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="photos">
							<div class="timeline">
								<div class="tab-content-heading">
									<h4>Photos</h4>						
								</div>
								<div class="about-dtp">
									<div class="photo-bg">
										<div class="gallery-pf">
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-1.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-2.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-3.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-4.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-5.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-6.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-7.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-8.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-6 col-6">	
													<div class="photo-gallery">
														<img src="{{url('public/assets/images/restaurant-detail/photo-2.jpg')}}" alt="">
														<a href="#"><i class="far fa-plus-square"></i></a>
													</div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="reviews">
							<div class="timeline">
								<div class="tab-content-heading">
									<h4>Reviews</h4>
								</div>
								<div class="main-comments">
									<div class="rating-1">
										<div class="user-detail-heading">
											<a href="#"><img src="{{url('public/assets/images/recipe-details/comment-5.png')}}" alt=""></a>
											<h4> Joy Cutler</h4><br>
											<div class="rate-star">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>								
												<span>4.5</span> 
											</div>
										</div>
										<div class="reply-time">											
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p>Morbi hendrerit ipsum vel feugiat maximus. Duis posuere justo neque, sit amet efficitur quam aliquam non. Integer gravida ex quis lacinia consectetur.</p>
										</div>
										
									</div>
																
									<div class="like-comment-dt">
										<ul>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
													<i class="fas fa-heart"></i>
													<ins>Like 562</ins>
												</span>
											</li>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
													<i class="fas fa-comment-alt"></i>
													<ins>Comments 01</ins>
												</span>
											</li>												
										</ul>
									</div>
									<div class="reply-review-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											<h4> Rock Smith</h4>
										</div>
										<div class="reply-time">								
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p> Thank you</p>
										</div>
										<div class="like-report">
											<ul>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
														<i class="fas fa-heart"></i>
														<ins>Like 1</ins>
													</span>
												</li>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
														<ins>Report</ins>
													</span>
												</li>												
											</ul>
										</div>
									</div>
									<div class="reply-comment">
										<div class="post-items">											
											<div class="reply-dp">
												<a href="http://www.gambolthemes.net/natto-new-demo/my_dashboard.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											</div>
											<form>
												<input type="text" class="comment-input-1" name="post" placeholder="Write a comment - @tag friends">
												<input class="reply-btn btn-link" type="submit" value="Post">
											</form>
										</div>
									</div>
								</div>
								<div class="main-comments">
									<div class="rating-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/comment-2.png" alt=""></a>
											<h4> Jassica William</h4><br>
											<div class="rate-star">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>								
												<span>4.5</span> 
											</div>
										</div>
										<div class="reply-time">											
											<p><i class="far fa-clock"></i>13 hours ago</p>
										</div>
										<div class="comment-description">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum leo sit amet volutpat porta. Integer tincidunt id enim eget suscipit. Aenean vitae mi at arcu pulvinar dictum. Donec pretium ipsum diam, vitae posuere nunc dapibus ut. Vivamus tempus et magna at elementum. Morbi sed turpis vitae elit pellentesque pharetra vel ut nisl.</p>
										</div>
										
									</div>
																
									<div class="like-comment-dt">
										<ul>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
													<i class="fas fa-heart"></i>
													<ins>Like 562</ins>
												</span>
											</li>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
													<i class="fas fa-comment-alt"></i>
													<ins>Comments 0</ins>
												</span>
											</li>												
										</ul>
									</div>
									
									<div class="reply-comment">
										<div class="post-items">											
											<div class="reply-dp">
												<a href="http://www.gambolthemes.net/natto-new-demo/my_dashboard.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											</div>
											<form>
												<input type="text" class="comment-input-1" name="post" placeholder="Write a comment - @tag friends">
												<input class="reply-btn btn-link" type="submit" value="Post">
											</form>
										</div>
									</div>
								</div>
								<div class="main-comments">
									<div class="rating-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/comment-1.png" alt=""></a>
											<h4> John Doe</h4><br>
											<div class="rate-star">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>								
												<span>4.5</span> 
											</div>
										</div>
										<div class="reply-time">											
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p>Morbi hendrerit ipsum vel feugiat maximus. Duis posuere justo neque, sit amet efficitur quam aliquam non. Integer gravida ex quis lacinia consectetur.</p>
										</div>
										
									</div>								
									<div class="like-comment-dt">
										<ul>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
													<i class="fas fa-heart"></i>
													<ins>Like 562</ins>
												</span>
											</li>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
													<i class="fas fa-comment-alt"></i>
													<ins>Comments 01</ins>
												</span>
											</li>												
										</ul>
									</div>
									<div class="reply-review-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/reply-1.png" alt=""  ></a>
											<h4> Rock Smith</h4>
										</div>
										<div class="reply-time">								
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p> Thank you</p>
										</div>
										<div class="like-report">
											<ul>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
														<i class="fas fa-heart"></i>
														<ins>Like 1</ins>
													</span>
												</li>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
														<ins>Report</ins>
													</span>
												</li>												
											</ul>
										</div>
									</div>
									<div class="reply-comment">
										<div class="post-items">											
											<div class="reply-dp">
												<a href="http://www.gambolthemes.net/natto-new-demo/my_dashboard.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											</div>
											<form>
												<input type="text" class="comment-input-1" name="post" placeholder="Write a comment - @tag friends">
												<input class="reply-btn btn-link" type="submit" value="Post">
											</form>
										</div>
									</div>
								</div>
							</div>	
						</div>
						<div class="tab-pane" id="ratings">
							<div class="timeline">
								<div class="tab-content-heading">
									<h4>Ratings</h4>
								</div>
								<div class="main-comments">
									<div class="rating-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/comment-5.png" alt=""></a>
											<h4> Joy Cutler</h4><br>
											<div class="rate-star">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>								
												<span>4.5</span> 
											</div>
										</div>
										<div class="reply-time">											
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p>Morbi hendrerit ipsum vel feugiat maximus. Duis posuere justo neque, sit amet efficitur quam aliquam non. Integer gravida ex quis lacinia consectetur.</p>
										</div>
										
									</div>
									<div class="review-tags">
											<p><ins>Tags :</ins><a href="#">Johnson,</a> <a href="#"> Jasica,</a><a href="#"> Joy William,</a> <a href="#"> Johnson,</a><a href="#"> Jass Singh,</a>&nbsp; <span> and</span>&nbsp; <a href="#">8 others</a></p>
									</div>
									<div class="post-images">
										<div class="select-images">
											<ul>
												<li class="image-select">
													<img src="images/restaurant-detail/add-1.jpg" alt="">														
												</li>
												<li class="image-select">
													<img src="images/restaurant-detail/add-2.jpg" alt="">
												</li>
												<li class="image-select">
													<img src="images/restaurant-detail/add-3.jpg" alt="">														
												</li>
											</ul>													
										</div>
									</div>
									<div class="like-comment-dt">
										<ul>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
													<i class="fas fa-heart"></i>
													<ins>Like 562</ins>
												</span>
											</li>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
													<i class="fas fa-comment-alt"></i>
													<ins>Comments 01</ins>
												</span>
											</li>												
										</ul>
									</div>
									<div class="reply-review-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											<h4> Rock Smith</h4>
										</div>
										<div class="reply-time">								
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p> Thank you</p>
										</div>
										<div class="like-report">
											<ul>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
														<i class="fas fa-heart"></i>
														<ins>Like 1</ins>
													</span>
												</li>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
														<ins>Report</ins>
													</span>
												</li>												
											</ul>
										</div>
									</div>
									<div class="reply-comment">
										<div class="post-items">											
											<div class="reply-dp">
												<a href="http://www.gambolthemes.net/natto-new-demo/my_dashboard.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											</div>
											<form>
												<input type="text" class="comment-input-1" name="post" placeholder="Write a comment - @tag friends">
												<input class="reply-btn btn-link" type="submit" value="Post">
											</form>
										</div>
									</div>
								</div>
								<div class="main-comments">
									<div class="rating-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/comment-2.png" alt=""></a>
											<h4> Jassica William</h4><br>
											<div class="rate-star">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>								
												<span>4.5</span> 
											</div>
										</div>
										<div class="reply-time">											
											<p><i class="far fa-clock"></i>13 hours ago</p>
										</div>
										<div class="comment-description">
											<p>Duis posuere justo neque, sit amet efficitur quam aliquam non. Integer gravida ex quis lacinia consectetur.</p>
										</div>
										
									</div>
									<div class="review-tags">
											<p><ins>Tags :</ins><a href="#">Johnson,</a> <a href="#"> Rock Hunter,</a> <a href="#"> Joy William,</a> <a href="#"> Johnson,</a><a href="#"> Jass Singh,</a>&nbsp; <span> and</span>&nbsp; <a href="#">8 others</a></p>
									</div>							
									<div class="like-comment-dt">
										<ul>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
													<i class="fas fa-heart"></i>
													<ins>Like 562</ins>
												</span>
											</li>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
													<i class="fas fa-comment-alt"></i>
													<ins>Comments 0</ins>
												</span>
											</li>												
										</ul>
									</div>
									
									<div class="reply-comment">
										<div class="post-items">											
											<div class="reply-dp">
												<a href="http://www.gambolthemes.net/natto-new-demo/my_dashboard.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											</div>
											<form>
												<input type="text" class="comment-input-1" name="post" placeholder="Write a comment - @tag friends">
												<input class="reply-btn btn-link" type="submit" value="Post">
											</form>
										</div>
									</div>
								</div>
								<div class="main-comments">
									<div class="rating-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/comment-1.png" alt=""></a>
											<h4> John Doe</h4><br>
											<div class="rate-star">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>								
												<span>4.5</span> 
											</div>
										</div>
										<div class="reply-time">											
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p>Morbi hendrerit ipsum vel feugiat maximus. Duis posuere justo neque, sit amet efficitur quam aliquam non. Integer gravida ex quis lacinia consectetur.</p>
										</div>
										
									</div>
									<div class="review-tags">
											<p><ins>Tags :</ins><a href="#">Johnson,</a> <a href="#"> Jasica,</a><a href="#"> Joy William,</a> <a href="#"> Johnson,</a><a href="#"> Jass Singh,</a>&nbsp; <span> and</span>&nbsp; <a href="#">8 others</a></p>
									</div>
									<div class="post-images">
										<div class="select-images">
											<ul>
												<li class="image-select">
													<img src="images/restaurant-detail/add-1.jpg" alt="">
													<div class="post">
														<a href="#" data-toggle="modal" data-target="#videoModal-2"><div class="play-btn"><i class="fas fa-play"></i></div></a>
													</div>
													<div class="modal fade " id="videoModal-2" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
													  <div class="modal-dialog modal-lg">
														<div class="modal-content">
														  <div class="modal-body">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
															<div>
															  <iframe height="450" src="https://www.youtube.com/embed/6CFJhTKcGJ4" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
															</div>
														  </div>
														</div>
													  </div>
													</div>
												</li>												
											</ul>													
										</div>
									</div>
									<div class="like-comment-dt">
										<ul>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
													<i class="fas fa-heart"></i>
													<ins>Like 562</ins>
												</span>
											</li>
											<li>
												<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
													<i class="fas fa-comment-alt"></i>
													<ins>Comments 01</ins>
												</span>
											</li>												
										</ul>
									</div>
									<div class="reply-review-1">
										<div class="user-detail-heading">
											<a href="user_profile_view.html"><img src="images/recipe-details/reply-1.png" alt=""  ></a>
											<h4> Rock Smith</h4>
										</div>
										<div class="reply-time">								
											<p><i class="far fa-clock"></i>12 hours ago</p>
										</div>
										<div class="comment-description">
											<p> Thank you</p>
										</div>
										<div class="like-report">
											<ul>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Likes">
														<i class="fas fa-heart"></i>
														<ins>Like 1</ins>
													</span>
												</li>
												<li>
													<span class="views" data-toggle="tooltip" data-placement="top" title="Comments">
														<ins>Report</ins>
													</span>
												</li>												
											</ul>
										</div>
									</div>
									<div class="reply-comment">
										<div class="post-items">											
											<div class="reply-dp">
												<a href="http://www.gambolthemes.net/natto-new-demo/my_dashboard.html"><img src="images/recipe-details/reply-1.png" alt=""></a>
											</div>
											<form>
												<input type="text" class="comment-input-1" name="post" placeholder="Write a comment - @tag friends">
												<input class="reply-btn btn-link" type="submit" value="Post">
											</form>
										</div>
									</div>
								</div>
							</div>	
						</div>
						<div class="tab-pane" id="order-history">
							<div class="timeline">
								<div class="tab-content-heading">
									<h4>Order History</h4>
								</div>
								<div class="my-orders">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12">
											<div class="my-checkout">
												<div class="table-responsive">
													<table class="table  table-bordered">
														<thead>
															<tr>
																<td class="td-heading">Meal</td>
																<td class="td-heading">Qty</td>
																<td class="td-heading">Price</td>
																<td class="td-heading">Action</td>
																
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>
																	<div class="checkout-thumb-2">
																		<a href="meal_detail.html">
																			<img src="images/profile/order-1.jpg" class="img-responsive" alt="thumb" title="thumb">
																		</a>
																	</div>
																	<div class="name-dt">
																		<a href="meal_detail.html"><h4>Hum Burgar</h4></a>
																		<a href="restaurant_detail.html"><p>Restaurant Name</p></a>
																		
																	</div>
																</td>									
																<td class="td-content">2</td>										
																<td class="td-content">$22.00</td>
																<td>
																	<button class="trace-btn btn-link">Completed</button>															
																	<button class="invoice-btn btn-link"><i class="far fa-file-alt"></i></button>
																	<button class="trash-btn btn-link"><i class="far fa-trash-alt"></i></button>																																
																</td>																
															</tr>	
															<tr>
																<td>
																	<div class="checkout-thumb-2">
																		<a href="meal_detail.html">
																			<img src="images/profile/order-2.jpg" class="img-responsive" alt="thumb" title="thumb">
																		</a>
																	</div>
																	<div class="name-dt">
																		<a href="meal_detail.html"><h4>Cheese Pizza</h4></a>
																		<a href="restaurant_detail.html"><p>Restaurant Name</p></a>
																		
																	</div>
																</td>									
																<td class="td-content">1</td>										
																<td class="td-content">$18.00</td>
																<td>
																	<button class="trace-btn btn-link">Completed</button>															
																	<button class="invoice-btn btn-link"><i class="far fa-file-alt"></i></button>
																	<button class="trash-btn btn-link"><i class="far fa-trash-alt"></i></button>																																
																</td>																
															</tr>
															<tr>
																<td>
																	<div class="checkout-thumb-2">
																		<a href="meal_detail.html">
																			<img src="images/profile/order-3.jpg" class="img-responsive" alt="thumb" title="thumb">
																		</a>
																	</div>
																	<div class="name-dt">
																		<a href="meal_detail.html"><h4>Veg Noodles</h4></a>
																		<a href="restaurant_detail.html"><p>Restaurant Name</p></a>
																		
																	</div>
																</td>									
																<td class="td-content">1</td>										
																<td class="td-content">$20.00</td>
																<td>
																	<button class="trace-btn btn-link">Completed</button>															
																	<button class="invoice-btn btn-link"><i class="far fa-file-alt"></i></button>
																	<button class="trash-btn btn-link"><i class="far fa-trash-alt"></i></button>																																
																</td>																
															</tr>		
															<tr>
																<td>
																	<div class="checkout-thumb-2">
																		<a href="meal_detail.html">
																			<img src="images/profile/order-4.jpg" class="img-responsive" alt="thumb" title="thumb">
																		</a>
																	</div>
																	<div class="name-dt">
																		<a href="meal_detail.html"><h4>Chicken Masala</h4></a>
																		<a href="restaurant_detail.html"><p>Restaurant Name</p></a>																		
																	</div>
																</td>									
																<td class="td-content">1</td>										
																<td class="td-content">$25.00</td>
																<td>
																	<button class="trace-btn btn-link">Completed</button>															
																	<button class="invoice-btn btn-link"><i class="far fa-file-alt"></i></button>
																	<button class="trash-btn btn-link"><i class="far fa-trash-alt"></i></button>																																
																</td>																
															</tr>		
														</tbody>														
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
				
			</div>
		</div>
	</section>
	<!--my-account-tabs end-->
@endsection

