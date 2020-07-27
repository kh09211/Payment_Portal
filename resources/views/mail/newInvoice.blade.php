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

	<h1 style="margin: 0; margin-bottom: 30px; margin-top:30px; text-align:center" class="mt-3" align="center">
			Invoice # {{ $invoice->id }} from Kyleweb.dev
	</h1>

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
	                    <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">Description: </h5>
	                </div>
	                <div class="col-8 " style="width:70%" width="70%">
	                    <h5 class="unbold description ml-3 mr-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; margin-right:30px; font-weight:400"> {{ $invoice->description }}</h5>
	                </div>
	            </div>

	            <div class="row d-flex" style="display:flex">
	                <div class="col-4 " style="width:30%" width="30%">
	                    <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">Created on: </h5>
	                </div>
	                <div class="col-8 " style="width:70%" width="70%">
	                    <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">{{ $invoice->created_at->format('m-d-y') }}</h5>
	                </div>
	            </div>


	            
	            @isset($itemized)
	                <div style="margin-top:20px; margin-bottom:30px">
	                    <div class="row d-flex" style="display:flex">
	                        <div class="col-4 " style="width:30%" width="30%">
	                            <div class="ml-3" style="margin-left:30px"><h4 style="margin:0; margin-bottom:5px">Task Hours</h4></div>
	                        </div>
	                        <div class="col-8 " style="width:70%" width="70%">
	                             <div class="ml-3" style="margin-left:30px"><h4 style="margin:0; margin-bottom:5px">Task Description</h4></div>
	                        </div>
	                    </div>
	                    <hr class="ml-3 mr-3" style="margin-left:30px; margin-right:30px">
	                    @foreach($itemized as $item)
	                    @if ($loop->first)
	                        {{-- skip the first iteration as it is not an item--}}
	                        @continue
	                    @endif
	                        <div class="row d-flex " style="display:flex">
	                            <div class="col-4" style="width:30%" width="30%">
	                                <div style="padding-left:60px">{{ number_format($item['item-hours'], 2) }}</div>
	                            </div>
	                            <div class="col-8" style="width:70%" width="70%">
	                                 <div style="padding-left: 30px; padding-right:30px;">{{ $item['item-desc'] }}</div>
	                            </div>
	                        </div>

	                    @endforeach
	                </div>
	            @endisset


	            @if ($invoice->rate != null)
	                <div class="row d-flex" style="display:flex">
	                    <div class="col-4" style="width:30%" width="30%">
	                        <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">Rate / Hour: </h5>
	                    </div>
	                    <div class="col-8" style="width:70%" width="70%">
	                        <h5 class="unbold  ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400">${{ $invoice->rate }}</h5>
	                    </div>
	                </div>
	            @endif



	            @if ($invoice->hours != null)
	                <div class="row d-flex" style="display:flex">
	                    <div class="col-4 " style="width:30%" width="30%">
	                        <h5 class="ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400;">Total hours: </h5>
	                    </div>
	                    <div class="col-8" style="width:70%" width="70%">
	                        <h5 class=" ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; font-weight:400;">{{ $invoice->hours }}</h5>
	                    </div>
	                </div>
	            @endif

	            @if ($invoice->price != null)
	                <div class="row d-flex" style="display:flex">
		                <div class="col-4 " style="width:30%" width="30%">
		                    <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; color: red;">Amount due:  </h5>
		                </div>
		                <div class="col-8 " style="width:70%" width="70%">
		                    <h5 class="unbold ml-3" style="margin:3px 0 0 0; font-size:16px; padding:0; margin-left:30px; color: red;">${{ number_format($invoice->price, 2) }}</h5>
		                </div>
	            	</div>
	            @endif

	            




	            <div class="pay-link-box" style="border-color:blue; border-style:solid; border-width:1px; margin:30px 10% 30px 10%; padding:10px 10px 15px 10px; text-align:center" align="center">
	            	<a href="http://invoice.kyleweb.dev/invoices/{{ $invoice->id }}">
	            		<h5 style="margin:3px 0 0 0; font-size:16px; padding:0">Click here to view and pay</h5>
	            	</a>
	            </div>

	            <p class="ml-3 mr-3" style="margin:0; text-align:left; text-indent:15px; margin-left:30px; margin-right:30px" align="left">This email is an automatically generated invoice for the above services rendered. For any quesions regarding this invoice or payments, please contact kyle@kyleweb.dev. Thank you, your business is well appreciated!</p>
	            <p style="margin:0; text-align:left; text-indent:15px; margin-left:60px; margin-top: 5px;" align="left"> Sincerely, Kyle Hopkins</p>
	    </div>

</body>
</html>