@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <div>Transactions History</div>
                  <div>Today: {{ date('M-d-Y') }}</div>
                </div>
                <div class="card-body">
                    <div id="index-table">
                        <table class="table text-center">
                          <thead>
                            <tr>
                              <th scope="col" class="d-none d-md-table-cell">Transaction #</th>
                              <th scope="col" class="d-none d-md-table-cell">Invoice #</th>
                              <th scope="col">Name</th>
                              <th scope="col">View Details</th>
                              <th scope="col">Paid On</th>
                              <th scope="col" class="d-none d-md-table-cell">Method of payment</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                              <td class="d-none d-md-table-cell">{{ $transaction->id }}</th>
                              <td class="d-none d-md-table-cell">{{ $transaction->invoice_id }}</th>
                              <td>{{ $transaction->invoice->name }}</td>
                              <td><a href="/invoices/{{ $transaction->invoice_id }}" class="text-primary">View Invoice</a></td>
                              <td>{{ $transaction->created_at->format('M-d-Y') }}</td>
                              <td class="d-none d-md-table-cell">{{ $transaction->payment_method }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
