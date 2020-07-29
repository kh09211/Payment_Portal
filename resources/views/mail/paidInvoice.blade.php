<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html charset=UTF-8">

	<style>
    .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%;
    }
    .ExternalClass {
    	width: 100%;
    }
	</style>
</head>
<body>

	<h1 style="margin: 0; margin-top:30px; text-align:center;" class="mt-3" align="center">
			Invoice # {{ $invoice->id }} from Kyleweb.dev
	</h1>
	<h3 style="margin: 0; margin-top: 10px; margin-bottom: 30px; text-align:center; color: green;" class="mt-3" align="center">
			has been paid, Thank you!
	</h3>

	<div class="card-body mb-3" style="margin-bottom:30px">
	        <div class="row d-flex" style="display:flex">
	            <div class="col-4 " style="width:30%" width="30%">
	                <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">Name: </h5>
	            </div>
	            <div class="col-8 " style="width:70%" width="70%">
	                <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">{{ $invoice->name }}</h5>
	            </div>
	        </div>

	        <div class="row d-flex" style="display:flex">
	            <div class="col-4 " style="width:30%" width="30%">
	                <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">Date/Time: </h5>
	            </div>
	            <div class="col-8 " style="width:70%" width="70%">
	                <h5 class="unbold description ml-3 mr-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">{{ now() }} EST</h5>
	            </div>
	        </div>

	        <div class="row d-flex" style="display:flex">
	            <div class="col-4 " style="width:30%" width="30%">
	                <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">Amount Paid: </h5>
	            </div>
	            <div class="col-8 " style="width:70%" width="70%">
	                <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">${{ number_format($invoice->price, 2) }}</h5>
	            </div>
	        </div>

	        

	        <p class="ml-3 mr-3" style="margin:0; text-align:left; text-indent:15px; margin-left:30px; margin-right:30px; margin-top: 30px;" align="left">This email serves only as a receipt of payment for the above services rendered. For any quesions regarding this transaction, please contact kyle@kyleweb.dev. Thank you for your payment, your business is very much appreciated!</p>
	        <p style="margin:0; text-align:left; text-indent:15px; margin-left:60px; margin-top: 5px;" align="left"> Sincerely, Kyle Hopkins</p>
	</div>

</body>
</html>