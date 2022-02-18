<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Transactions extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = 'HEKTO';
        $address = env('MAIL_FROM_ADDRESS');
        $subject = 'Hekto Order Confirmation, Thank you for placing an order';
        
        
        return $this->view('mail.transactions')

        ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with([
                'data' => $this->data,   
            ]);
    }
}
