<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Transaction;
use Illuminate\Support\Facades\Mail;

class ChargeController extends Controller
{
    /**
     * make a simple charge
     *
     * @return \Illuminate\Http\Response
     */
    public function simple(Request $request)
    {

        // validate form data before continuing
        $paymentRequest = $request->validate([
                'paymentMethodId' => ['required', 'string', 'max:255'],
                'invoiceId' => ['required', 'numeric'],
                'emailGuest' => ['email', 'max:255', 'nullable']
            ]);

        // set vars passed from javascript
        $paymentMethodId = $paymentRequest['paymentMethodId'];
        $invoiceId = $paymentRequest['invoiceId'];
        $emailGuest = $paymentRequest['emailGuest'];


        $invoice = Invoice::find($invoiceId);
        $invoicePrice = $invoice->price * 100; // stripe only allows integers for price

        // create a user so that the charge can be processed
        $stripeCharge = (new \App\User)->charge($invoicePrice, $paymentMethodId, ['description' => 'Invoice# ' . $invoiceId . ' - Checkout as Guest']);

        if ($stripeCharge->status == 'succeeded') {
            $invoice->paid = true;
            $invoice->save();

            // create a transaction record
            Transaction::createTransaction($invoiceId, 'Stripe');

            //send reciept if email provided upon guest checkout. if not will send only to admin
            mail::send(new \App\Mail\PaidInvoice($invoice, $emailGuest));

            return 'succeeded';
        } 
    }

    public function paypal(Request $request) {
        // fires off when recieves axios call from show.blade after a paypal pmt
        $invoiceId = $request->input('invoiceId');
        $invoice = Invoice::find($invoiceId);
        
        //change to paid
        $invoice->paid = true;
        $invoice->save();

        // create a transaction record
        Transaction::createTransaction($invoiceId, 'Paypal');

        //send email to admin to notify of payment
        mail::send(new \App\Mail\PaidInvoice($invoice, null));

        return 'succeeded';
    }
}
