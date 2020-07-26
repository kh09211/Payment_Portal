<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use \App\Invoice;

class PaidInvoice extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, $emailGuest)
    {
        $this->invoice = $invoice;
        $this->emailGuest = ($emailGuest) ? $emailGuest : null;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invoice = $this->invoice;
        
        // build the email object
        if ($this->emailGuest) {
            
            // if customer gives email addy, use it, if not still send me a notification
            return $this->to($this->emailGuest)->bcc(config('app.ADMIN_EMAIL'))
                ->subject('Invoice #' . $invoice->id . " for " . $invoice->name . " has been paid!")
                ->view('mail.paidInvoice', compact('invoice'));
        } else {

            //if emailGuest is null
            return $this->to(config('app.ADMIN_EMAIL'))
                ->subject('Invoice #' . $invoice->id . " for " . $invoice->name . " has been paid!")
                ->view('mail.paidInvoice', compact('invoice'));
        }
    }
}
