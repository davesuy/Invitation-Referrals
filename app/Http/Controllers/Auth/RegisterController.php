<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
   // protected $redirectTo = RouteServiceProvider::HOME;

    
    protected $redirectTo = '/referrals';

    protected function redirectTo()
    {
       
        Session::flash('message', 'Thank you for Registering and you can start referring now!');
        
        
        return '/referrals';
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
      
        if($referral = $request->referral(request()->cookie('refer'))) {
           // dd($refer->token);

           $user_referral_visits = User::where('id', $referral->user_id)->value('referral_visits');

           //dd( $user_referral_visits);

            
           /**
            * Using Session to count referral visit without incrementing for page refresh.
            */

         
           
           if(Cookie::get('refer')) {

                    
                $viewCounter = Session::get('viewed_pages', []);

                if(!in_array($referral->token, $viewCounter)){

                    User::where('id', $referral->user_id)->update([
                        'referral_visits' => $user_referral_visits + 1
                    ]);
                    
                    Session::push('viewed_pages', $referral->token);
                }

              

                
           } 

           //dd($viewCounter);

        
              
          
          
        }
     
        return view('auth.register');
    }

        /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {

       // dd($request->referral(request()->cookie('refer')));

       if($referral = $request->referral(request()->cookie('refer'))) {

            $user_referral_count = User::where('id', $referral->user_id)->value('referral_count');
            $user_referral_points = User::where('id', $referral->user_id)->value('referral_points');

            User::where('id', $referral->user_id)->update([
                'referral_count' => $user_referral_count + 1,
                'referral_points' => $user_referral_points + 10,
            ]);

            $referral->complete();

       }

        event(new Registered($user));
    }
}
