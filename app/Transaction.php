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
}
