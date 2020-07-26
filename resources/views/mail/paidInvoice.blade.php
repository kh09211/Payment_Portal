<style>
	.card-body {
		width: 100%;
	}
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
	p {
		text-align: left;
		text-indent: 15px;
	}

	@media screen and (max-width: 370px) {
		
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
		display: flex;
	}
	.col-8 {
		width: 80%;
		text-align: left;
		display: flex;
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
			Invoice # {{ $invoice->id }} at Kyleweb.dev
	</h1>
	<h3 style="text-align: center" class="text-danger">
			Has been successfully paid!
	</h3>

	    <div class="card-body">
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
                <div class="col-4">
                    <h5 class="ml-3 unbold">Date/Time: </h5>
                </div>
                <div class="col-8">
                    <h5 class="ml-3 unbold description">{{ date(DATE_RSS) }}</h5>
                </div>
            </div>

            
            <div class="row d-flex">
                <div class="col-4">
                    <h5 class="ml-3">Amount Paid: </h5>
                </div>
                <div class="col-8">
                    <h5 class="ml-3 price">${{ number_format($invoice->price, 2) }}</h5>
                </div>
            </div>

            <p class="ml-3 mr-3">This email serves only as a receipt of payment for the above services rendered. For any quesions regarding this transaction, please contact kyle@kyleweb.dev. Thank you for your payment, your business is well appreciated!</p>
            <p style="margin-left: 60px"> Sincerely, Kyle Hopkins</p>
	    </div>
	
</html>