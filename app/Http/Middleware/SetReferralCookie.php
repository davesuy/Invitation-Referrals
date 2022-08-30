<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Referral;
use Illuminate\Http\Request;

class SetReferralCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       

        if($referral = $request->referral($request->refer)) {
           // dd($referral);
            cookie()->queue(cookie()->forever('refer', $referral->token));

        }
        
        return $next($request);
    }
}
