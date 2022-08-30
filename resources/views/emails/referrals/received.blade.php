@component('mail::message')

<h1 style="font-size: 22px">{{ $sender->name }}  has been using ContactOut, and thinks it could be of use for you. </h1>


<strong>Here’s their invitation link for you:</strong>  
<a href='{{ route('register', ['refer' => $referral->token]) }}'>{{ route('register', ['refer' => $referral->token]) }}</a>

{{-- @component('mail::button', ['url' => route('register', ['refer' => $referral->token])])
    Sign Up now
@endcomponent --}}

ContactOut gives you access to contact details for about 75% of the world’s professionals.  
  
Great for recruiting, sales, and marketing outreach.  
  
It’s an extension that works right on top of LinkedIn.  
  
<strong>Here’s their invitation link again:</strong>  
<a href='{{ route('register', ['refer' => $referral->token]) }}'>{{ route('register', ['refer' => $referral->token]) }}</a>

@endcomponent
