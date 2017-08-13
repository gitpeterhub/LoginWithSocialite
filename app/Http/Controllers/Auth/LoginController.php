<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;

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
    protected $redirectTo = '/admin/dashboard';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //to authenticate using username instead email by default
    /*public function username()
    {
        return 'username';
    }*/
    //for social login purposes
    /**
     * Redirect the user to the social media authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();

    }

    /**
     * Obtain the user information from social media.
     *
     * @return Response
     */
    public function handleProviderCallback($service)
    {
   
        try {
            $user = Socialite::driver($service)->user();


        } catch (Exception $e) {
            return redirect()->to('/');
        }
 
        $authUser = $this->findOrCreateUser($user);
 
        Auth::login($authUser, true);
 
         return redirect()->route('dashboard');


       /* // OAuth Two Providers
        $token = $user->token;
        $refreshToken = $user->refreshToken; // not always provided
        $expiresIn = $user->expiresIn;

        // OAuth One Providers
        $token = $user->token;
        $tokenSecret = $user->tokenSecret;*/

        // All Providers
        /*$user->getId();
        $user->getNickname();
        
        
        $user->getAvatar();*/

    }


/**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */

     private function findOrCreateUser($user)
    {
        $authUser = User::where([
                            ['name','=',$user->getName()],
                            ['email','=',$user->getEmail()]
                        ])->first();
 
        if ($authUser){
            return $authUser;
        }else{
            return User::create([
            //'username' => $user->getName(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => bcrypt(str_random(64))
        ]);
    }      
}
}
