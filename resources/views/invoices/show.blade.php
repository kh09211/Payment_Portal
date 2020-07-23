@extends('layouts.app')

@section('content')

@section('css')
<style>
    .StripeElement {
      background-color: white;
      padding: 8px 12px;
      border-radius: 4px;
      border: 1px solid #C0C0C0;
      /* box-shadow: 0 1px 3px 0 #e6ebf1; */
      -webkit-transition: box-shadow 150ms ease;
      transition: box-shadow 150ms ease;
      width: 100%;
      height: 37px;
    }

    
    .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #348fdb;
      border-color: #a1cbef;
      border-width: 1px;
    }
    
    .StripeElement--invalid {
      border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }

    input.w-100:focus {
      box-shadow: 0 1px 3px 0 #3490dc; /* works properly */
    }
</style>
@endsection


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="ml-2">INVOICE #<span id="invoice-id">{{ $invoice->id }}</span></div>
                        <div class="mr-2">Last Update: {{ $invoice->updated_at->format('m-d-y') }} </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif ($invoice->paid)
                        <div class='alert alert-danger' role="alert">
                            This invoice has been paid!
                        </div>
                    @else
                        @can('update', $invoice)
                            @if (! $invoice->paid)
                                <div class="row justify-content-end">
                                    <a class="mr-3 mb-3 @if(! $invoice->email) d-none @endif " href="/invoices/{{ $invoice->id }}/mail">Send Email</a>
                                    <a class=" ml-3 mr-3 mb-3" href="/invoices/{{ $invoice->id }}/edit">Edit Invoice</a>
                                </div>
                            @endif
                        @endcan
                    @endif

            {{-- if invoice has been paid, hide details, except for admin--}}
                    @if (! $invoice->paid || Gate::allows('see-admin'))
                        <div class="row d-flex">
                            <div class="col-4 text-right">
                                <h5>Name: </h5>
                            </div>
                            <div class="col-8">
                                <h5>{{ $invoice->name }}</h5>
                            </div>
                        </div>

                        <div class="row d-flex">
                            <div class="col-4 text-right">
                                <h5>Description: </h5>
                            </div>
                            <div class="col-8 pr-md-5">
                                <h5>{{ $invoice->description }}</h5>
                            </div>
                        </div>

                        <div class="row d-flex">
                            <div class="col-4 text-right">
                                <h5>Created on: </h5>
                            </div>
                            <div class="col-8">
                                <h5>{{ $invoice->created_at->format('m-d-y') }}</h5>
                            </div>
                        </div>


                        @if ($invoice->rate != null)
                            <div class="row d-flex">
                                <div class="col-4 text-right">
                                    <h5>Rate / Hour: </h5>
                                </div>
                                <div class="col-8">
                                    <h5>${{ $invoice->rate }}</h5>
                                </div>
                            </div>
                        @endif

                        
                        @isset($itemized)
                            <div class="mt-2 mb-3 py-2">
                                <div class="row">
                                    <div class="col-4 text-right">
                                        <div>Task Hours</div>
                                    </div>
                                    <div class="col-8">
                                         <div>Task Description</div>
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
                                        <div class="col-8 pr-md-5">
                                             <div>{{ $item['item-desc'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        @can('update', $invoice)
                        @if(! $invoice->paid)
                            <form action="/invoices/{{ $invoice->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row d-flex">
                                <div class="col-2 ml-2">
                                    Hours
                                </div>
                                <div class="col-8">
                                    Task
                                </div>
                            </div>
                            <div class="row d-flex no-gutters form-group">
                                <div class="col-2">
                                    <input id="item-hours" name="item-hours" type="text" class="w-100" style="margin-left: 1px;">
                                </div>
                                <div class="col-8">
                                    <input id="item-desc" name="item-desc" type="text" class="w-100">
                                </div>
                                <div class="col-2">
                                    <input type="submit" value="Add Task" class="w-100" style="margin-left: -1px;">
                                </div>
                            </div>
                        @endif
                        @endisset
                        @endcan


                        @if ($invoice->hours != null)
                            <div class="row d-flex">
                                <div class="col-4 text-right">
                                    <h5>Total hours: </h5>
                                </div>
                                <div class="col-8">
                                    <h5>{{ $invoice->hours }}</h5>
                                </div>
                            </div>
                        @endif

                        @if ($invoice->price != null)
                            <div class="row d-flex">
                                <div class="col-4">
                                    <h5 class="text-danger text-right">Amount due: </h5>
                                </div>
                                <div class="col-8">
                                    <h5 class="text-danger">${{ number_format($invoice->price, 2) }}</h5>
                                </div>
                            </div>
                        @endif


                        
                        @cannot('update', $invoice)
                            
                            {{-- <hr class="mx-1"> --}}
                            <div class="mt-4 mb-3"></div>
                            <div class="row mt-2 align-items-center border pt-4 pb-1 mx-1">
                                <div class="col-12 justify-content-center pb-2">
                                  <div class="row justify-content-center d-flex my-1">
            {{--
                                    <div class="h5 mr-2"><a href="#">Sign in with Google</a></div>
                                    <div class="h5">or</div>
              --}}
                                    <div class="h5 ml-2">Checkout as Guest:</div>
                                  </div>
                                </div>
                                <div class="col-12 mt-2">
                                  <label class="h5">Cardholder Name: </label>
                                </div>
                                <div class="col-12">
                                  <input id="card-holder-name" class="form-control w-100" type="text" placeholder="Name on Card">
                                </div>
                                

                                <!-- Stripe Elements Placeholder -->
                                <div class="col-12 mt-3">
                                    <label class="h5">Credit / Debit Card: </label>
                                </div>
                                <div class="col-12">
                                  <div id="card-element" class="form-control"></div>
                                </div>


                                <div class="col-12 mt-3">
                                  <label class="h5">Email for Receipt (optional): </label>
                                </div>
                                <div class="col-12">
                                  <input type="email" id="email" class="form-control w-100" placeholder="Email Address">
                                </div>
                                <div class="col-12 text-center">
                                  <button class ="btn btn-outline-primary mt-4" id="card-button">
                                    Process Payment
                                  </button>
                                  <div id="processing" class="invisible mt-2">Processing your payment. Please wait...</div>
                                </div>
                            </div>
                        @endcannot
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div id="stripe-key" style="display: none;">{{ env('STRIPE_KEY')}}</div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
    const invoiceId = document.getElementById('invoice-id').innerHTML;

    const stripeKey = document.getElementById('stripe-key').innerHTML
    const stripe = Stripe(stripeKey);

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {
        cardButton.disabled = true; // disable the button so payment cannot be resubmitted
        document.getElementById('processing').classList.remove('invisible'); // make the processing pmt text visible
        const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement, {
                billing_details: { name: cardHolderName.value }
            }
        );

        if (error) {
            console.log(error);
        } else {
            console.log(paymentMethod.id);

            // use axios to send the guest charge to the server
            axios.post('/charge_simple', {'paymentMethodId' : paymentMethod.id, 'invoiceId' : invoiceId}).then(res => {
                if (res.data = 'succeeded') {
                    location.reload(); // reload the page
                } 
            }).catch(function (error) {
                let processingError = document.getElementById('processing');
                    processing.innerHTML = "There has been an error. Please contact kyle@kyleweb.dev";
                    processing.classList.add('text-danger');
                console.log(error);
            });
        }
    });
    </script>
@endpush