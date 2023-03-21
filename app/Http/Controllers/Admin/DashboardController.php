<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use DB;
USE Hash;
use Charts;
use File;
use Auth;
class DashboardController extends Controller {
    
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function service_provider(){
        return view('admin.service_provider.list');
    }
    public function bookings(){
        return view('admin.bookings.list');
    }
    public function edit_service_provider(){
    	return view('admin.service_provider.edit');
    }
    public function event_service(){
        return view('admin.service_provider.list');
    }
    public function users(){
    	return view('admin.users.list');
    }

    public function user_edit(){
    	return view('admin.users.edit');
    }
    public function reviews(){
    	return view('admin.ratings.list');
    }

    public function tickets_user(){
    	return view('admin.tickets_user.user_list');
    }
}
