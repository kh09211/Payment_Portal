@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ADMIN CONTROL PANEL</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row d-flex justify-content-center">
                        <a href="/invoices" class="btn btn-primary mr-2">Invoices Index</a>
                        <a href="/transactions" class="btn btn-primary ml-2">Transactions Index</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
