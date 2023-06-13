<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard || {{$setting[0]->site_title}}</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{url('assets/web/images/favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{url('assets/web/images/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{url('assets/web/images/favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{url('assets/web/images/favicon/site.webmanifest')}}">
  <link rel="mask-icon" href="{{url('assets/web/images/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="{{url('assets/parsley/parsley.css')}}">
  <link rel="stylesheet" href="{{url('assets/adminn/vendors/datatables/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{url('assets/web/fancybox/jquery.fancybox.min.css')}}" media="all" />
  <link rel="stylesheet" href="{{url('assets/adminn/css/app.min.css')}}">
  <link rel="stylesheet" href="{{url('assets/adminn/css/style.css')}}">
  <script src="{{url('assets/adminn/js/jquery.min.js')}}"></script>
  <style>
    .inner-menu {
      list-style: none;
    }
  </style>
</head>

<body>
  <div class="app">
    <div class="layout">
      <div class="header">
        <div class="logo">
          <a class="navbar-brand brand-logo " href="{{url('admin/dashboard')}}">
            <img src="{{url(''.$setting[0]->logo)}}" alt="logo" />
            <img class="logo-fold" src="{{url(''.$setting[0]->icon)}}" alt="Logo">
          </a>
        </div>
        <div class="nav-wrap">
          <ul class="nav-left">
            <li class="desktop-toggle">
              <a href="javascript:void(0);">
                <i class="anticon"></i>
              </a>
            </li>
            <li class="mobile-toggle">
              <a href="javascript:void(0);">
                <i class="anticon"></i>
              </a>
            </li>
          </ul>
          <ul class="nav-right">
            <li class="dropdown dropdown-animated scale-left">
              <div class="pointer" data-toggle="dropdown">
                <div class="avatar avatar-image  m-h-10 m-r-15">
                  <img src="{{url('assets/web/images/favicon/apple-touch-icon.png')}}" alt="">
                </div>
              </div>
              <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                  <div class="d-flex m-r-50">
                    <div class="avatar avatar-lg avatar-image">
                      <img src="{{url('assets/web/images/favicon/apple-touch-icon.png')}}" alt="">
                    </div>
                    <div class="m-l-10">
                      <p class="m-b-0 text-dark font-weight-semibold">{{Auth::user()->name}}</p>
                      @if(Auth::user()->user_type=='superadmin')
                      <p class="m-b-0 opacity-07">Super Admin</p>
                      @endif
                    </div>
                  </div>
                </div>
				
                @if(Auth::user()->user_type=='vendor')
                <a href="{{route('my_profile')}}" class="dropdown-item d-block p-h-15 p-v-10">
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                      <span class="m-l-10">View Profile</span>
                    </div>
                    <i class="anticon font-size-10 anticon-right"></i>
                  </div>
                </a>
                @endif
				
                <a href="#" class="dropdown-item d-block p-h-15 p-v-10">
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      <i class="anticon opacity-04 font-size-16 anticon-key"></i>
                      <span class="m-l-10">Change Password</span>
                    </div>
                    <i class="anticon font-size-10 anticon-right"></i>
                  </div>
                </a>
                <a href="{{route('admin_logout')}}" class="dropdown-item d-block p-h-15 p-v-10">
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                      <span class="m-l-10">Logout</span>
                    </div>
                    <i class="anticon font-size-10 anticon-right"></i>
                  </div>
                </a>
              </div>
            </li>

            <li>
              <a href="javascript:void(0);" data-toggle="modal" data-target="#quick-view">
                <i class="anticon anticon-appstore"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- Header END -->
      <div class="side-nav">
        <div class="side-nav-inner">
          <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown user-login {{(in_array(Route::getCurrentRoute()->getName(),[ 'my_profile',]))? 'open':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-user"></i></span>
                <span class="title">Welcome {{Auth::user()->name}}</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="{{(in_array(Route::getCurrentRoute()->getName(),[ 'my_profile',]))? 'active':'' }}">
                  <a href="{{route('my_profile')}}">View Profile</a>
                </li>
                <li class="">
                  <a href="javascript:void(0);">Change Password</a>
                </li>
                <li>
                  <a href="{{route('admin_logout')}}">Logout</a>
                </li>
              </ul>
            </li>
            @if(Auth::user()->user_type=='superadmin')
            <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'admin_dashboard',]))? 'active':'' }}">
              <a href="{{route('admin_dashboard')}}">
                <span class="icon-holder"><i class="anticon anticon-dashboard"></i></span>
                <span class="title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'vendor_list','vendor_payments']))? 'open':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-shop"></i></span>
                <span class="title">Vendors</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="{{(in_array(Route::getCurrentRoute()->getName(),[ 'vendor_list',]))? 'active':'' }}"><a href="{{route('vendor_list')}}">Vendor</a></li>
                <li class="{{(in_array(Route::getCurrentRoute()->getName(),[ 'vendor_payments',]))? 'active':'' }}"> <a href="{{route('vendor_payments')}}">Vendor Payments</a></li>
              </ul>
            </li>
			@endif
            <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'category_list','sub_category_list','child_category_list','products','product_stock','product_bulk_upload','unapproved_products','deleted_products','brand_list']))? 'open':'' }}">
              <a href="javascript:void(0);" class="dropdown-toggle">
                <span class="icon-holder">
                  <i class="anticon anticon-appstore"></i>
                </span>
                <span class="title">Catalog</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                @if(Auth::user()->isactive=='1')
                <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[]))? 'active':'' }}">
                  <a href="javascript:void(0);" class="dropdown-toggle">
                    <span class="title">Products</span>
                    <span class="arrow">
                      <i class="arrow-icon"></i>
                    </span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="nav-item {{(Route::getCurrentRoute()->getName()=='products')?'active':''}}"><a href="{{route('products')}}">All Products</a></li>

                    <li class="nav-item {{(Route::getCurrentRoute()->getName()=='product_stock')?'active':''}}"><a href="{{route('product_stock')}}">Product Stock Status</a></li>

                    <li class="nav-item {{(Route::getCurrentRoute()->getName()=='product_bulk_upload')?'active':''}}"><a href="{{route('product_bulk_upload')}}">Products Bulk Upload</a></li>

                    <li class="nav-item {{(Route::getCurrentRoute()->getName()=='unapproved_products')?'active':''}}"><a href="{{route('unapproved_products')}}">Disapproved Products</a></li>

                    <li class="nav-item {{(Route::getCurrentRoute()->getName()=='deleted_products')?'active':''}}"><a href="{{route('deleted_products')}}">Deleted products</a></li>
                    <!-- 
                      <li class="nav-item {{(Route::getCurrentRoute()->getName()=='deleted_products')?'active':''}}"><a href="{{route('product_bundle')}}">  Product Bundle</a></li> -->
                  </ul>
                </li>
                @endif
                @if(Auth::user()->user_type=='superadmin')
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'category_list','sub_category_list','child_category_list']))? 'active':'' }}">
                  <a href="{{route('category_list')}}">
                    Categories
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'brand_list']))? 'active':'' }}">
                  <a href="{{route('brand_list')}}">
                    Brands
                  </a>
                </li>
				@endif
				
				
              </ul>
            </li>
          @if(Auth::user()->user_type=='superadmin')
            <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'coupens','send_mail']))? 'open':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-sound"></i></span>
                <span class="title">Promotions</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'coupens',]))? 'active':'' }}">
                  <a href="{{route('coupens')}}">
                    <span class="title">Coupons</span>
                  </a>
                </li>

                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'send_mail',]))? 'active':'' }}">
                  <a href="{{route('send_mail')}}">
                    <span class="title">Send mail</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'admin_orders','sale']))? 'open':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-inbox"></i></span>
                <span class="title">Orders</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'admin_orders',]))? 'active':'' }}">
                  <a href="{{route('admin_orders')}}">
                    <span class="title">Orders</span>
                  </a>
                </li>

                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'sale',]))? 'active':'' }}">
                  <a href="{{route('sale')}}">
                    <span class="title">Sale</span>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'admin_orders','sale']))? 'open':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-inbox"></i></span>
                <span class="title">Market</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'market_settings',]))? 'active':'' }}">
                  <a href="{{route('market_settings')}}">
                    <span class="title">setting</span>
                  </a>
                </li>

                
              </ul>
            </li>
            
            <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'customer', 'admin_staff']))? 'open':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-team"></i></span>
                <span class="title">Users</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'customer',]))? 'active':'' }}">
                  <a href="{{route('customer')}}">
                    <span class="title">Customer</span>
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'admin_staff',]))? 'active':'' }}">
                  <a href="{{route('admin_staff')}}">
                    <span class="title">Admin Sub Users</span>
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'customer_wallet',]))? 'active':'' }}">
                  <a href="{{route('customer_wallet')}}">
                    <span class="title">Customer wallet</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'delivery']))? 'open':'' }}">
              <a href="javascript:void(0);" class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-rocket"></i></span>
                <span class="title">Shipping/Pickup</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
              <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'shippingcompany',]))? 'active':'' }}">
                  <a href="javascript:void(0);">
                    <span class="title">Shipping Company</span>
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'delivery',]))? 'active':'' }}">
                  <a href="{{route('delivery')}}">
                    <span class="title">Delivery Fee</span>
                  </a>
                </li>
              </ul>
            </li>
            
			<li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),['product_stock_report','vendor_payment_report','payment_history']))? 'active':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-pie-chart"></i></span>
                <span class="title">Reports</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item {{(Route::getCurrentRoute()->getName()=='product_stock_report')?'active':''}}">
                  <a href="{{route('product_stock_report')}}">Stock Report</a>
                </li>
                <li class="nav-item {{(Route::getCurrentRoute()->getName()=='payment_history')?'active':''}}">
                  <a href="{{route('payment_history')}}">Payment History</a>
                </li>
                <li class="nav-item {{(Route::getCurrentRoute()->getName()=='sale_report')?'active':''}}">
                  <a href="{{route('sale_report')}}">Sale Report</a>
                </li>
              </ul>
            </li>
            <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'pages',]))? 'active':'' }}">
                <a href="{{route('pages')}}">
                    <span class="icon-holder"><i class="anticon anticon-copy"></i></span>
                    <span class="title">Pages</span>
                  </a>
              </li>
            <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'home_page_setting',]))? 'active':'' }}">
              <a href="{{route('home_page_setting')}}">
                <span class="icon-holder"><i class="anticon anticon-home"></i></span>
                <span class="title">Home Page Setup</span>
              </a>
            </li>
			
			  <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),[ 'banner_list','general_setting']))? 'open':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-setting"></i></span>
                <span class="title">System Settings</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'general_setting']))? 'active':'' }}">
                  <a href="{{route('general_setting')}}">
                    <span class="title">General Settings</span>
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'banner_list',]))? 'active':'' }}">
                  <a href="{{route('banner_list')}}">
                    <span class="title">Front Page Banner</span>
                  </a>
                </li> 
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'plugins',]))? 'active':'' }}">
                  <a href="javascript:void(0);">
                    <span class="title">Plugins</span>
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'commission',]))? 'active':'' }}">
                  <a href="javascript:void(0);">
                    <span class="title">Commission Settings</span>
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'pin_codes',]))? 'active':'' }}">
                  <a href="{{route('pin_codes')}}">
                    <span class="title">Pin Codes</span>
                  </a>
                </li>
                <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'seo',]))? 'active':'' }}">
                  <a href="{{route('pin_codes')}}">
                    <span class="title">SEO</span>
                  </a>
                </li>
              </ul>
            </li>
            
            
			
            @endif
			  
     @if(Auth::user()->user_type=='vendor')
				 
	        <li class="nav-item dropdown {{(in_array(Route::getCurrentRoute()->getName(),['product_stock_report','vendor_payment_report','payment_history']))? 'active':'' }}">
              <a href="javascript:void(0);  " class="dropdown-toggle">
                <span class="icon-holder"><i class="anticon anticon-pie-chart"></i></span>
                <span class="title">Reports</span>
                <span class="arrow">
                  <i class="arrow-icon"></i>
                </span>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item {{(Route::getCurrentRoute()->getName()=='product_stock_report')?'active':''}}">
                  <a href="{{route('product_stock_report')}}">Stock Report</a>
                </li>
                <li class="nav-item {{(Route::getCurrentRoute()->getName()=='payment_history')?'active':''}}">
                  <a href="{{route('payment_history')}}">Payment History</a>
                </li>
                <li class="nav-item {{(Route::getCurrentRoute()->getName()=='sale_report')?'active':''}}">
                  <a href="{{route('sale_report')}}">Sale Report</a>
                </li>
              </ul>
             </li>
			
               <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'send_mail']))? 'open':'' }}">
                    <a class="nav-link" href="{{route('send_mail')}}">
                      <span class="icon-holder"><i class="fa fa-list-alt menu-icon"></i></span>
                      <span class="title">Mail Support</span>
                    </a>
              </li>
			  
			  <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'my_sale']))? 'open':'' }}">
                    <a class="nav-link" href="{{route('my_sale')}}">
                      <span class="icon-holder"><i class="fa fa-list-alt menu-icon"></i></span>
                      <span class="title">Order History</span>
                    </a>
              </li>
			  <li class="nav-item {{(in_array(Route::getCurrentRoute()->getName(),[ 'notifications']))? 'open':'' }}">
                    <a class="nav-link" href="{{route('notifications')}}">
                      <span class="icon-holder"><i class="anticon anticon-setting"></i></span>
                      <span class="title">Notifications</span>
                    </a>
              </li>`
              @endif
          </ul>
        </div>
      </div>
      <div class="page-container">
        <div class="main-content">
          @yield('content')
        </div>
      </div>
      <div class="modal modal-right fade quick-view" id="quick-view">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header justify-content-between align-items-center">
              <h5 class="modal-title">Quick View</h5>
            </div>
            <div class="modal-body scrollable">
              <!-- Content goes Here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{url('assets/adminn/js/vendors.min.js')}}"></script>
  <script src="{{url('assets/parsley/parsley.js')}}"></script>
  <script type="text/javascript" src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="{{url('assets/adminn/vendors/datatables/jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript" src="{{url('assets/web/fancybox/jquery.fancybox.min.js')}}"></script>
  <script src="{{url('assets/adminn/js/pages/datatables.js')}}"></script>
  <script src="{{url('assets/adminn/js/app.min.js')}}"></script>
  <script type="text/javascript">
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#show_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    console.log(1)
  </script>

  <script type="text/javascript">
    function delete_row(id, table) {
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: '{{route("delete_row")}}',
              data: {
                id: id,
                table: table
              },
              cache: false,
              success: function(res) {
                if (res) {
                  $('#' + id + '').fadeOut(1200).css({
                    'background-color': '#f2dede'
                  });
                }
              }
            });
          }
        });
    }
  </script>
  <script type="text/javascript">
    /* De Active Row*/
    function active_row(id, table, status) {
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            /*  $.ajax({
               url:'{{route("delete_row")}}',
               data:{id:id,table:table},
               cache:false,
               success:function(res){
                 if (res) {
                   $('#'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
                 }
               }
             }); */
          }
        });
    }
  </script>
  <script type="text/javascript">
    /* Active Row*/
    function deactive_row(id, table, status) {
      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            /*  $.ajax({
               url:'{{route("delete_row")}}',
               data:{id:id,table:table},
               cache:false,
               success:function(res){
                 if (res) {
                   $('#'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
                 }
               }
             }); */
          }
        });
    }
    get_notification()

    function get_notification() {
      id = "{{Auth::user()->id}}";
      $.ajax({
        url: '{{route("get_notification_count")}}',
        data: {
          id: id
        },
        cache: false,
        success: function(res) {
          $('.no').html(res);
        }
      });
    }
  </script>
</body>

</html>