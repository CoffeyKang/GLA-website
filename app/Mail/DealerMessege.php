<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DealerMessege extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;
    public function __construct(Array $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Email messege from retail website -- Dealer Account.")->from('info@goldenleafautomotive.com')
        ->bcc('ayeh@goldenleafautomotive.com')
        ->bcc('sales@goldenleafautomotive.com')
        ->bcc('fkang@velements.com')
        ->view('emails.dealerMessege');
    }
}
