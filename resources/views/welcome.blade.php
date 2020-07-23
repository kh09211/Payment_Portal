@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-light h1 text-center mt-3">Welcome to the Payment Portal application!</div>
            <div class="text-center h5 text-light my-4">Here you may view and pay your invoices. To access your invoice, please follow the link given in your email or enter your invoice number below. If you do not have either, please contact <a class="text-light" href="mailto:kyle@kyleweb.dev"><u>kyle@kyleweb.dev</u></a> or use the <a class="text-light" href="http://kyleweb.dev/#contact"><u>Contact Form</u></a>.</div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="height: 15px;"></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('existsInvoice') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="invoice" class="col-md-4 col-form-label text-md-right"><h5>Invoice # </h5></label>

                            <div class="col-md-4">
                                <input id="invoice" type="text" class="form-control @error('invoice') is-invalid @enderror" name="invoice" value="{{ old('invoice') }}" required autofocus>

                                @error('invoice')
                                    <span class="invalid-feedback mt-2" role="alert">
                                        <h6><strong>{{ $message }}</strong></h6>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mt-3 mt-md-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('View Invoice') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
