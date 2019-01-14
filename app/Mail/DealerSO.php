<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Dealer;
use App\DealerHistory;
use App\AddressBook;

class DealerSO extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $dealer;

    public $dealerHistory;

    public $account;
    
    public function __construct(DealerHistory $dealerHistory)
    {
        

        $this->dealerHistory = $dealerHistory;

        $this->dealer = $dealerHistory->fullname();

        
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.dealerSO')
        ->from('sales@goldenleafautomotive.com')
        ->bcc('ayeh@goldenleafautomotive.com')
        ->cc('sales@goldenleafautomotive.com')
        ->bcc('fkang@velements.com')
        ->subject('Golden Leaf automotive. (DO NOT REPLY)');
    }
}
