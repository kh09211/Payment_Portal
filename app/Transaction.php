<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function Invoice() {

    	return $this->belongsTo(Invoice::class);
    }

    public function user() {

    	return $this->belongsTo(User::class);
    }

    public static function createTransaction($invoice_id, $payment_method, $user_id = NULL) {
        // create a transaction after a payment has been made

        $transaction = new Transaction;
        $transaction->invoice_id = $invoice_id;
        $transaction->payment_method = $payment_method;
        $transaction->user_id = $user_id;

        $transaction->save();

        return true;
    }
}
