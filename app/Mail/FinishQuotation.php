<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\SOMAST;
use App\SOTRAN;
use App\Billing;
use App\AddressBook;

class FinishQuotation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;

    public $somast;

    public $sotran;

    public $billing;

    public $address;
    
    public function __construct(User $user, SOMAST $somast, Billing $billing, AddressBook $address)
    {
        $this->user = $user;

        $this->somast = $somast;

        $this->billing = $billing;

        $this->address = $address;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.finishQuotation')->from('service@goldenleafautomotive.com')
        ->bcc('ayeh@goldenleafautomotive.com')
        ->bcc('service@goldenleafautomotive.com')
        ->bcc('fkang@velements.com')
        ->subject('Golden Leaf automotive. (DO NOT REPLY)');
    }
}
