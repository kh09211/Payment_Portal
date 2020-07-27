@extends('layouts.app')

@section('css')
<style>
    ul.nav a {
        color: white;
        font-size: 18px;
    }    

    #trash {
        width:23px;
    }
</style>
@endsection

@section('content')

<div class="container">

    <ul class="nav justify-content-center mt-n3 mb-3">
      <li class="nav-item">
        <a class="nav-link" href="/invoices">Unpaid Invoices</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/invoices?sort=paid">Paid Invoices</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="/invoices?sort=all">All Invoices</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="invoices/create">New Invoice</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/transactions">Transactions</a>
      </li>
    </ul>      
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $sort }} Invoices (arranged by last updated)</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="index-table">
                        <table class="table text-center">
                          <thead>
                            <tr>
                              <th scope="col">Invoice #</th>
                              <th scope="col">Name</th>
                              <th scope="col">View / Edit</th>
                              <th scope="col" class="d-none d-md-table-cell">Last Update</th>
                              <th scope="col" class="d-none d-md-table-cell">Created On</th>
                              <th scope="col">Delete Invoice</th>
                            </tr>
                          </thead>
                          <tbody>
                            {{-- Changes text-color based on paid and removes dates for mobile view--}}
                            @foreach($invoices as $invoice)
                            <tr class="@if($invoice->paid == true) text-success @else text-danger @endif ">
                              <td class="text-dark">{{ $invoice->id }}</th>
                              <td>{{ $invoice->name }}</td>
                              <td><a href="/invoices/{{ $invoice->id }}" class="text-primary">View Invoice</a></td>
                              <td class="d-none d-md-table-cell">{{ $invoice->updated_at->format('M-d-Y') }}</td>
                              <td class="d-none d-md-table-cell">{{ $invoice->created_at->format('M-d-Y') }}</td>
                              <td>
                                <form action="/invoices/{{ $invoice->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @if(! $invoice->paid)
                                      <input type="image" id="trash" src="{{ asset('images/trash.png') }}">
                                    @endif
                                </form>
                              </td>
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
