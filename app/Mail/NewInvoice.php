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
        return $this->to($invoice->email)->bcc('kyle@kyleweb.dev')
            ->subject('Kyleweb.dev - New Invoice #' . $this->invoice->id . " is now available to view and pay!")
            ->view('mail.newInvoice', compact('invoice'));
    }
}
