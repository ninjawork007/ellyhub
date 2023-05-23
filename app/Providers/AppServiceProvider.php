<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()   {
      
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()   {
        view()->composer('*',function($settings){ 
			  $settings->with('top_brand', DB::table('brand')->where('status','yes')->where('feature','yes')->get()->toarray()); 
             $settings->with('top_cat', DB::select(DB::raw("SELECT id,name,image,slug  FROM categories WHERE  isactive  = 'active' AND home_category='1'")));
             $settings->with('all_main_categories', DB::select(DB::raw("SELECT id,name,image,slug  FROM categories WHERE  isactive  = 'active' ")));
             $settings->with('all_sub_categories', DB::select(DB::raw("SELECT id,title,category_id  FROM sub_categories ")));
             $settings->with('all_child_categories', DB::select(DB::raw("SELECT id,name,category_id,sub_category_id  FROM child_categories ")));
             $settings->with('setting', DB::select(DB::raw("SELECT * FROM settings WHERE id='1'")));
         });
    }

  


}
