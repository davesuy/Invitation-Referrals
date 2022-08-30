@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header">{{ __('My Referrals Status') }}               
                          (        

                       @if($referrals->count())
                            @php

                            
                                echo App\Http\Controllers\Referrals\ReferralController::getUserByEmail($referrals[0]->user_id );
                            
                            
                                
                            @endphp

                        @endif
                          )
                   </div>

                <div class="card-body">
                    @if($referrals->count())
                        <table class="table">
                  
                            <thead>

                                <tr>
                                    <th>Referral Visits</th>                           
                                    <th>Referral Count</th>
                                    <th>Referral Points</th>
                                </tr>

                            </thead>
                            <tbody>

                            
                                <tr>    
                                    <td>{{ $user->referral_visits }}</td>
                             
                                    <td>{{ $user->referral_count }}</td>

                                    <td>{{ $user->referral_points }}</td>

                                </tr>

                            </tbody>

                        
                        

                        </table>
                    @else
                        <p class="mb-0">
                            No referrals...
                        </p>
                    
                    @endif
                </div>
            </div>
            



        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header">{{ __('Referrals') }}</div>

                <div class="card-body">
                    @if($referrals->count())
                        <table class="table">
                            <thead>

                                <tr>
                                    <th>Email</th>                           
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>

                            </thead>
                            <tbody>

                            
                                @foreach($referrals as $referral)

                                    <tr>
                                
                                        <td>                         
                                            {{ $referral->email }}
                                          
                                        </td>

                                        <td>
                                            {{ $referral->created_at->toDateString() }}
                                        </td>

                                        <td>
                                            @if($referral->completed)
                                                Signed Up
                                            @else
                                                Not yet Signed &nbsp; <a href="{{ route('index', ['refer' => $referral->token])}}" class="" target="_blank">Get Link</a>
                                            @endif
                                        </td>

                                    </tr>

                                @endforeach
                                

                            </tbody>

                        

                        </table>
                    @else
                        <p class="mb-0">
                            No referrals...
                        </p>
                    
                    @endif
                </div>
            </div>
            



        </div>
    </div>
</div>
@endsection
