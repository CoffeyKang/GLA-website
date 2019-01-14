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

class Reminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $somast;

    public $sotran;

    public $billing;

    public $address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        return $this->view('emails.reminder')
        ->from('service@goldenleafautomotive.com')
        ->bcc('ayeh@goldenleafautomotive.com')
        ->bcc('service@goldenleafautomotive.com')
        ->bcc('fkang@velements.com')
        ->subject("Order Quotation Reminder. (DO NOT REPLY)");
    }
}
