@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h1 class="text-light mt-2">About Payment Portal</h1>
        </div>
        <div class="col-md-6 text-center">
            <img class="border rounded my-4 w-100" style="border-top: 0px !important; border-right: 0px !important;" src="{{ asset('images/screenshot.jpg') }}" alt="screenshot on admin menu">
        </div>
        
        <div class="w-100"></div>
        <div class="col-md-8 text-center mt-3 px-3">
            <h5 class="text-left text-light">&nbsp&nbsp This application is part of Kyleweb.dev and built by Developer Kyle Hopkins. The goal of this application was to streamline the invoicing process, keeping track of work performed per client, to easily accept payments, to send neccessary emails, and centrally store all transaction records.</h5>

            <h5 class="text-left text-light">The site was built using Laravel PHP framework for the back end and a front end of Javascript and Bootstrap 4. Emails are generated with dynamic content and custom CSS styling. Other technologies utilized were the Paypal SDK, Axios for API calls, and Laravel Cashier for Stripe transactions.</h5>

            <h5 class="text-left text-light pt-1">&nbsp&nbsp If you are interested in having something similar custom built to serve your business, feel free to <a href="http://kyleweb.dev/#contact" class="text-light"><u>contact me</u></a> and we can get you exactly what you need. Thanks for reading about the application and making your payment. Your business is very much appreciated!</h5>

            <h5 class="ml-5 mt-4 mb-3 text-left text-light">Sincerely, Kyle</h5>
        </div>
    </div>
</div>
@endsection
