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
        return $this->to($this->invoice->email)->bcc(env('ADMIN_EMAIL'))
            ->subject('New Invoice #' . $this->invoice->id . " is now available to view and pay! - Kyleweb.dev")
            ->view('mail.newInvoice', compact('invoice'));
    }
}
