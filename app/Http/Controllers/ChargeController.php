<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Transaction;

class ChargeController extends Controller
{
    /**
     * make a simple charge
     *
     * @return \Illuminate\Http\Response
     */
    public function simple(Request $request)
    {
        $paymentRequest = $request->all();

        // set vars passed from javascript
        $paymentMethodId = $paymentRequest['paymentMethodId'];
        $invoiceId = $paymentRequest['invoiceId'];

        $invoice = Invoice::find($invoiceId);
        $invoicePrice = $invoice->price * 100; // stripe only allows integers for price

        // create a user so that the charge can be processed
        $stripeCharge = (new \App\User)->charge($invoicePrice, $paymentMethodId, ['description' => 'Invoice# ' . $invoiceId . ' - Checkout as Guest']);

        if ($stripeCharge->status == 'succeeded') {
            $invoice->paid = true;
            $invoice->save();

            // create a transaction record
            Transaction::createTransaction($invoiceId, 'stripe');

            return 'succeeded';
        } 
    }
}
