@extends('layouts.app')

@section('content')

<div class="container">
    
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
                                    <th>Referred</th>
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
                                            @php
                                                echo App\Http\Controllers\Referrals\ReferralController::getUserByEmail($referral->user_id );
                                            @endphp
                                          
                                        </td>

                                        <td>
                                            {{ $referral->created_at->toDateString() }}
                                        </td>

                                        <td>
                                            @if($referral->completed)
                                                Signed Up
                                            @else
                                                Not yet Signed
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
