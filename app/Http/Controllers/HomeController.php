<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Auth Middleware added so that only logged in users can use a method on the HomeController
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Gate::allows('see-admin')) {
            
            // for now redirect to invoice index since all current operations can be handled from there
            return redirect('/invoices');
            
        } else {

            return view('home');
        }
    }
}
