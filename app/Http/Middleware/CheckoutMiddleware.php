<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\BusinessSetting;

class CheckoutMiddleware
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
        if (BusinessSetting::where('type', 'guest_checkout_active')->first()->value != 1) {
         //   dd("Catch errors for script and full tracking ( 1 )");
            if(Auth::check()){
              //  dd("Catch errors for script and full tracking ( 2 )");
                return $next($request);
            }
            else {
           //     dd("Catch errors for script and full tracking ( 3 )");
                session(['link' => url()->current()]);
                return redirect()->route('user.login');
            }
        }
        else{
            //dd("Catch errors for script and full tracking ( 4 )");
            return $next($request);
        }
    }
}
