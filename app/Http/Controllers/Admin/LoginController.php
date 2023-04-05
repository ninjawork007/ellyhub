<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use DB;
use Hash;
class LoginController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
    */
       
    
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct() {
        
    }
	//show admin page
	public function index(){
		
		return view('admin/login');
         
	}
	//function for submit admin login form
    public function attempt_login(Request $request){
        request()->validate([
            'email' => 'required', 'email',
            'password' => 'required', 'string', 'max:255'
        ]);

	   	$email = $request->email;
    	$password = $request->password;
    	// Check validation
		if (Auth::attempt(['email' => $email, 'password' => $password,'user_type'=>'superadmin'])) {
	        $user = Auth::user();
	        if ($user->user_type == "superadmin") {
	            return redirect()->route('admin_dashboard');
	        }
		} else {
            
            return back()->with('danger','Crediantials not matched with records.');
		    return redirect('/admin');
		}
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function logout(Request $request)
    {
        if (!Auth::user()) {
            return redirect('/admin');
        }
        $user = Auth::user();

		if ($user->user_type == "superadmin") {
		    Auth::logout();
        	return redirect('/admin');
		}else{
            Auth::logout();
            return redirect('/');
        }
    }
}
