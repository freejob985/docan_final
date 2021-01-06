<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Session;
use Config;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        //         $langs = 'en';

        // if (Session::get('locale') == 'en') {

        //     $langs == 'en';
        //     session()->put('locale', "en");

        // } elseif (Session::get('locale') == 'ar') {

        //     $langs == 'sa';
        //     session()->put('locale', "ar");

        // } elseif (Session::get('locale') == 'sa') {

        //     $langs == 'sa';
        //     session()->put('locale', "sa");

        // } else {

        //     $langs == 'en';
        //     session()->put('locale', "en");

        // }
        
        
        if(Session::has('locale')){
            
            $locale = Session::get('locale');

       // dd($locale);
        }
        elseif(env('DEFAULT_LANGUAGE') != null){
            $locale = env('DEFAULT_LANGUAGE');
        }
        else{
            $locale = 'ar';
        }

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}
