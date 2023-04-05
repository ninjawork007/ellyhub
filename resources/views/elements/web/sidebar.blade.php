<div class="col-lg-3 col-md-4">

                        <div class="left-side-tabs">

                            <div class="dashboard-left-links">

                                <a href="{{route('user_dashboard')}}" class="user-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'user_dashboard',]))? 'active':'' }}"><i class="uil uil-apps"></i>Dashboard</a>

                                <a href="{{route('user_orders')}}" class="user-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'user_orders',]))? 'active':'' }}"><i class="uil uil-location-point"></i>My Orders</a>

                                <a href="{{route('user_logout')}}" class="user-item"><i class="uil uil-exit"></i>Logout</a>

                            </div>

                        </div>

                    </div>