<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    // enables soft deletes meaning invoices only get a deleted_at attribute
    use softDeletes;

    // use attribute casting so that jason_encode/decode no longer needed. automatic
    protected $casts = ['itemized' => 'array'];

	// $attributes property in a model sets the default attibute for an object
	protected $attributes = [
		'paid' => false
	];

    // set guard to empty array to avoid mass assignment error
    protected $guarded = [];



    public function transaction() {

    	return $this->hasOne(Transaction::class);
    }
    public function user() {

    	return $this->belongsTo(User::class);
    }
    
}
