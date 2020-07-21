<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Invoice;


class TransactionController extends Controller
{
    public function __construct() {
        // Auth middleware no longer needed since the policy automatically denices access to guest
        // $this->middleware('auth');
    }
    
    public function index() {

    	// authorize admin to view transaction index via the policy
        // since the index doesnt need a specific model instance, authorize with class name as second arguement
    	$this->authorize('viewAny', Transaction::class);

    	return view('transactions/index');
    }

    public function show(Transaction $transaction) {
        // NOTE: This route is type hinted since the route segment, and Model type hint and Variable all share the same name. The instance of the ID of the transaction requested will be injected into this controller method. 

        // authorize who can view based on the TransactionPolicy
        $this->authorize('view', $transaction );

    	return view('transactions/show');
    }

    public function store(array $data, $invoice_id) {
        $invoice = Invoice::find($invoice_id);

        // since the transaction create method doesnt need a specific model instance, authorize with class name as second arguement
        $this->authorize('create', Transaction::class);

        return view('transactions/index');
    }
}
