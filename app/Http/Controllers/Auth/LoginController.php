<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('passportapp')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $passportUser = Socialite::driver('passportapp')->user();

        // Add to our database, see Socialite video
        $user = User::where('provider_id', $passportUser->getId())->first();

        if (!$user) {
            // add user to database
            $user = User::create([
                'email' => $passportUser->getEmail(),
                'name' => $passportUser->getName(),
                'provider_id' => $passportUser->getId(),
            ]);
        }

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }
}
