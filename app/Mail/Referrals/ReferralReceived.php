<?php

namespace App\Mail\Referrals;

use App\Models\Referral;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class ReferralReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;

    public $referral;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, Referral $referral)
    {
        $this->sender = $sender;
        $this->referral = $referral;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->sender->name.' recommends ContactOut')
            ->markdown('emails.referrals.received');
    }
}
