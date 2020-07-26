<style>
	.d-flex {
		display: flex;
	}
	.mt-3 {
		margin-top: 30px;
	}
	.mt-2 {
		margin-top: 10px;
	}
	.ml-3 {
		margin-left: 30px;
	}
	.mr-3 {
		margin-right: 30px;
	}
	.mb-3 {
		margin-bottom: 30px;
	}
	.mb-2 {
		margin-bottom: 10px;
	}
	.pay-link-box {
		text-align: center;
		border-style: solid;
		border-width: 1px;
		border-color: blue;
		padding: 10px;
		margin: 30px 10% 30px 10%;
	}

	p {
		text-align: left;
		text-indent: 15px;
	}

	@media screen and (max-width: 400px) {
		
		.ml-3 {
			margin-left: 5px;
		}
		.mr-3 {
			margin-right: 5px;
		}
		.description {
			margin-top: 25px;
		}
		.price {
			margin-left: 30px;
		}
		.pay-link-box {
			margin-top: 15px;
		}
	}

	h5 {
		font-size: 18px;
		padding: 0px;
		margin: 3px 0 0 0;
	}
	h4 {
		margin-bottom: 5px;
	}
	.col-4 {
		width: 20%;
	}
	.col-8 {
		width: 80%;
	}
	.text-danger {
		color: red;
	}
	.unbold {
		font-weight: 400;
	}
</style>

<html>
	<h1 style="text-align: center" class="mt-3">
			Invoice # {{ $invoice->id }} from Kyleweb.dev
	</h1>

	    <div class="card-body mb-3">
	            <div class="row d-flex">
	                <div class="col-4 ">
	                    <h5 class="unbold ml-3">Name: </h5>
	                </div>
	                <div class="col-8 ">
	                    <h5 class="unbold ml-3">{{ $invoice->name }}</h5>
	                </div>
	            </div>

	            <div class="row d-flex">
	                <div class="col-4 ">
	                    <h5 class="unbold ml-3">Description: </h5>
	                </div>
	                <div class="col-8 ">
	                    <h5 class="unbold description ml-3 mr-3"> {{ $invoice->description }}</h5>
	                </div>
	            </div>

	            <div class="row d-flex">
	                <div class="col-4 ">
	                    <h5 class="unbold ml-3">Created on: </h5>
	                </div>
	                <div class="col-8 ">
	                    <h5 class="unbold ml-3">{{ $invoice->created_at->format('m-d-y') }}</h5>
	                </div>
	            </div>


	            @if ($invoice->rate != null)
	                <div class="row d-flex">
	                    <div class="col-4">
	                        <h5 class="unbold ml-3">Rate / Hour: </h5>
	                    </div>
	                    <div class="col-8">
	                        <h5 class="unbold  ml-3">${{ $invoice->rate }}</h5>
	                    </div>
	                </div>
	            @endif

	            
	            @isset($itemized)
	                <div class="mt-2 mb-3 mt-2">
	                    <div class="row d-flex">
	                        <div class="col-4 ">
	                            <div class="ml-3"><h4>Task Hours</h4></div>
	                        </div>
	                        <div class="col-8 ">
	                             <div class="ml-3"><h4>Task Description</h4></div>
	                        </div>
	                    </div>
	                    <hr class="ml-3 mr-3">
	                    @foreach($itemized as $item)
	                    @if ($loop->first)
	                        {{-- skip the first iteration as it is not an item--}}
	                        @continue
	                    @endif
	                        <div class="row d-flex ">
	                            <div class="col-4 ml-3">
	                                <div class="ml-3">{{ number_format($item['item-hours'], 2) }}</div>
	                            </div>
	                            <div class="col-8 ">
	                                 <div class="ml-3 mr-3">{{ $item['item-desc'] }}</div>
	                            </div>
	                        </div>
	                    @endforeach
	                </div>
	            @endisset


	            @if ($invoice->hours != null)
	                <div class="row d-flex">
	                    <div class="col-4 ">
	                        <h5 class="ml-3">Total hours: </h5>
	                    </div>
	                    <div class="col-8">
	                        <h5 class=" ml-3">{{ $invoice->hours }}</h5>
	                    </div>
	                </div>
	            @endif

	            @if ($invoice->price != null)
	                <div class="row d-flex">
	                    <div class="col-4">
	                        <h5 class="text-danger ml-3">Amount due: </h5>
	                    </div>
	                    <div class="col-8">
	                        <h5 class="text-danger ml-3 price">${{ number_format($invoice->price, 2) }}</h5>
	                    </div>
	                </div>
	            @endif

	            <div class="pay-link-box">
	            	<a href="http://invoice.kyleweb.dev/invoices/{{ $invoice->id }}">
	            		<h5>Click here to view and pay</h5>
	            	</a>
	            </div>

	            <p class="ml-3 mr-3">This email is an automatically generated invoice for the above services rendered. For any quesions regarding this invoice or payments, please contact kyle@kyleweb.dev. Thank you, your business is well appreciated!</p>
	            <p style="margin-left: 60px"> Sincerely, Kyle Hopkins</p>
	    </div>
	
</html>