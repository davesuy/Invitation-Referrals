<?php

namespace App\Providers;

use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Request::macro('referral', function($token) {

            return Referral::whereToken($token)
            ->WhereNotCompleted()
            ->WhereNotFromUser(request()->user())
            ->first();
    
        });
    }
}
