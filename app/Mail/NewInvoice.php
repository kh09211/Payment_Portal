<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use \App\Invoice;

class NewInvoice extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $invoice = $this->invoice;
        $itemized = $invoice->itemized;

        // if the invoice is new within 1 day, send email with 'New'
        $isNew = ($this->invoice->created_at->format( 'm d' ) == $this->invoice->updated_at->format( 'm d' )) ? 'New ' : '';
        
        // build the email object
        return $this->to($invoice->email)->bcc(config('app.ADMIN_EMAIL'))
            ->subject($isNew . 'Invoice #' . $invoice->id . " for " . $invoice->name . " is available to view and pay!")
            ->view('mail.newInvoice', compact('invoice', 'itemized'));
    }
}
