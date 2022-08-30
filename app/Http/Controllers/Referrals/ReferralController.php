<?php

namespace App\Http\Controllers\Referrals;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;
use App\Rules\NotReferringSelf;
use App\Rules\NotReferringExisting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Referrals\ReferralReceived;


class ReferralController extends Controller
{

    public function __construct() {

        $this->middleware(['auth']);

    }

    public function index(Request $request) {

        $referrals = $request->user()->referrals()->orderBy('completed', 'asc')->get();
        

        return view('referrals.index', compact('referrals'));

    }

    public function list(Request $request) {

       
        $referrals = Referral::orderBy('completed', 'asc')->get();

        return view('referrals.list', compact('referrals'));

    }

    public function ownlist(Request $request) {

       
        $referrals = $request->user()->referrals()->orderBy('completed', 'asc')->get();

        $user = Auth::user();


        return view('referrals.ownlist', compact('referrals',  'user'));

    }

    public function store(Request $request) {

        $emailtag = $request->emailtag;

        $user = Auth::user();

        if (Referral::where('email', '=', $emailtag)->exists()) {

            return response()->json([
                'message' => 'This Email is already been invited!'
            ]);

        } elseif(  $user->email == $emailtag ) {

            return response()->json([
                'message' => 'You cannot refer yourself'
            ]);

        } else {

       
        }

        
        // $this->validate($request, [
        //     'email' => [
        //         //'required',
        //         'email',
        //        new NotReferringExisting($request->user()),
        //        new NotReferringSelf($request->user())
        //     ]
        // ]);

        // $referral = $request->user()->referrals()->create($request->only('email'));
        
        //dd( $request->email);


        // Mail::to( $referral->email)->send(
            
        //    new ReferralReceived($request->user(), $referral)
          
        // );

        //return back();
    }

    public function submitemail(Request $request) {

        $emails = $request->emailtag;

        $user = Auth::user();

     

       
        if($emails) {

            foreach($emails as $email) {

    
                    $referral = new Referral;
                    $referral->email =  $email;      
                    $referral->user_id =  $user->id;    
                    $referral->completed =  0;  
                    $referral->save();

                Mail::to( $email )->send(
                        
                    new ReferralReceived( $user, $referral)
                     
                 );
            }

        }

        return response()->json([
            'success_message' => 'Invitation Sent!'
        ]);

     
    
   

              // Mail::to( $referral->email)->send(
            
        //    new ReferralReceived($request->user(), $referral)
          
        // );

    }


    public function getUserByEmail($user_id) {

        $user = User::find($user_id)->email;
        return $user;
        
    }
    
}
