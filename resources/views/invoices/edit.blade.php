@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Invoice') }}</div>

                <div class="card-body">
                    <form method="POST" action="/invoices/{{ $invoice->id }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name / Domain') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $invoice->name }}" required>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $invoice->description }}" required>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $invoice->email }}" placeholder="(Optional)">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="rate" class="col-md-4 col-form-label text-md-right">{{ __('Rate: $ per hr') }}</label>

                            <div class="col-md-6">
                                <input id="rate" type="text" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ $invoice->rate }}"
                                @if($invoice->itemized)
                                    disabled
                                @endif
                                >

                                @error('rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hours" class="col-md-4 col-form-label text-md-right">{{ __('Hours') }}</label>

                            <div class="col-md-6">
                                <input id="hours" type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ $invoice->hours }}" 
                                @if($invoice->itemized)
                                    disabled
                                @endif
                                >

                                @error('hours')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Fixed Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $invoice->price }}"
                                @if($invoice->itemized)
                                    disabled
                                @endif
                                >

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label for="paid" class="col-md-4 col-form-label text-md-right">{{ __('Paid?') }}</label>

                            <div class="col-md-6">
                                <input id="paid" type="checkbox" class="" name="paid" value="true" 
                                    @if($invoice->paid == true)
                                        checked
                                    @endif
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            @isset($itemized)
                                <div class="mt-2 mb-3 py-2">
                                    <div class="row">
                                        <div class="col-4 text-right">
                                            <div>Task Hours</div>
                                        </div>
                                        <div class="col-7">
                                             <div>Task Description</div>
                                        </div>
                                        <div class="col-1">
                                            <img src="{{ asset('images/trash.png') }}" style="width: 20px;">
                                        </div>
                                    </div>
                                    <hr class="mt-1 mb-2">
                                    @foreach($itemized as $item)
                                    @if ($loop->first)
                                        {{-- skip the first iteration as it is not an item--}}
                                        @continue
                                    @endif
                                        <div class="row">
                                            <div class="col-4 text-right">
                                                <div class="mr-3">{{ number_format($item['item-hours'], 2) }}</div>
                                            </div>
                                            <div class="col-7 pr-md-2">
                                                 <div>{{ $item['item-desc'] }}</div>
                                            </div>
                                            <div class="col-1 pt-1">
                                                <input type="checkbox" class="ml-1" name="remove-items[]" value="{{ $loop->iteration - 1 }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endisset
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-secondary">submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
