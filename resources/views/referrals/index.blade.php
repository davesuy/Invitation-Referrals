@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        @if(Session::has('message'))
            <p class="alert alert-info text-center">{{ Session::get('message') }}</p>
        @endif

        <div class="col-md-8">


            <div class="card">
                <div class="card-header">{{ __('Refer Someone') }}</div>

                {{-- <div class="card-body">

                    <form method="POST" action="{{ route('referrals') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                
                           
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

 
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Invite') }}
                                </button>

                            </div>
                        </div>
                    </form>

                </div> --}}

                <div class="card-body">

                    <TagInput />

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

