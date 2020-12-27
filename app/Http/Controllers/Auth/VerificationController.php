<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\User;
use Carbon\Carbon;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verification_confirmation($code){
      
        $user = User::where('verification_code', $code)->first();
         
        if($user != null){
            $user->email_verified_at = Carbon::now();
            $user->save();

            flash(translate('Your email has been verified successfully'))->success();

        }
        else {
           // dd("Catch errors for script and full tracking ( 3 )");
            flash(translate('Sorry, we could not verifiy you. Please try again'))->error();
        }
                    //    dd("Catch errors for script and full tracking ( 2 )");

        return redirect()->route('dashboard');
    }
}
