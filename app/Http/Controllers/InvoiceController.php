<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Invoice;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

// Note: laravel is using route model binding to inject the model instance of the invoice requested to the methods that have type hited arguements with the same name;

class InvoiceController extends Controller
{   
    public function __construct() {

        // This method is inherited by a trait used in the controller class. It tells laravel to use the InvoicePolicy for all of the resource methods in this class. Note, for this to work correctly, you must create the controller with the --resource AND --model= option so that proper typehinting of the methods are created.
        $this->authorizeResource(Invoice::class, 'invoice');

    }


    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if sort query parameter given, give appropriate results

        if (isset($request->all()['sort']) && $request->all()['sort'] == 'all') {
            $invoices = \App\Invoice::all();
            $sort = "All";

        } else if (isset($request->all()['sort']) && $request->all()['sort'] == 'paid') {
            $invoices = Invoice::where('paid', true)->get();
            $sort = "Paid";

        } else {

            $invoices = Invoice::where('paid', false)->get();
            $sort = "Unpaid";

        }

        // sort invoices by creation date newest first
        $collection = collect($invoices);
        $sorted = $collection->sortByDesc('updated_at');
        $invoices = $sorted->values()->all();

        return view('invoices/index', compact('invoices', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // validate the incoming form data request
        // $request->all() turns the request object into an array
        $data = $this->validator($request->all())->validate();

        // run data var through the conversion function
        $data = $this->convert($data);

        // if itemized checked, start the array note:removed json_encode
        if (isset($data['itemized'])) {
            if ($data['itemized'] == 'checked') {
                $data['itemized'] = [['Hours' => 'Task Description']];
            }
        } else {

            $data['itemized'] = null;
        } 

        // generate a random invoice id#
        $data['id'] = $this->randID();

        Invoice::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'email' => $data['email'],
            'hours' => $data['hours'],
            'rate' => $data['rate'],
            'price' => $data['price'],
            'paid' => $data['paid'],
            'id' => $data['id'],
            'itemized' => $data['itemized']
        ]);

        // if already paid for, create a transaction record at the same time
        if ($data['paid']) {
            \App\Transaction::createTransaction($data['id'], 'other/cash');
        }

        // return to show the recently created invoice and where itemized task can be then added
        return redirect('invoices/' . $data['id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {   
        // Check to see if the invoice is itemized and if so, if it has any items set
        $itemized = $this->isItemized($invoice);

        return view('invoices/show', compact('invoice','itemized'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {   
        // Check to see if the invoice is itemized and if so, if it has any items set
        $itemized = $this->isItemized($invoice);

        return view('invoices/edit', compact('invoice','itemized'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //Check to see if the update is just adding an item or is from the full edit page then validate accordingly
        if ($request->input('item-hours') || $request->input('item-desc')) {

            // validate the update request, $request->all() returns the array
            $newItem = $this->itemValidator($request->all())->validate();
            
            // Add the new item to the invoice note:removed json_decode
            $itemized = $invoice->itemized;
            $itemized[] = $newItem;

            // set new hours and price to the invoice
            $this->calcNewItemizedHoursAndPrice($invoice, $itemized);

            // save all the new stuff note:removed json_encode due to casts
            $invoice->itemized = $itemized;
            $invoice->save();

        } else {

            // validate seporately items to be removed and update invoice var
            if ($request->input('remove-items') && is_array($request->input('remove-items'))) { 

                // check to see if it is an itemized invoice then decode to var
                $itemized = $this->isItemized($invoice);

                $removalArr = $request->input('remove-items');

                // remove items at once with array_diff_key note: needs to be flipped to work right, see doc
                $itemizedRemoved = array_diff_key($itemized, array_flip($removalArr));

                //reset the key values to remove gaps
                $itemizedRekeyed = array_values($itemizedRemoved);

                // set new hours and price to the invoice
                $this->calcNewItemizedHoursAndPrice($invoice, $itemizedRekeyed);
                
                // set to invoice
                $invoice->itemized = $itemizedRekeyed;

            }


            //validate the update request, $request->all() returns the array
            $data = $this->validator($request->all())->validate();

            //convert the data to floats and boolean
            $data = $this->convert($data);

            // update the object properties with the validated and converted data 
            foreach ($data as $key => $value) {
                $invoice->$key = $value;
            }

            $invoice->save();

            // if already paid for, create a transaction record at the same time
            if ($data['paid']) {
                \App\Transaction::createTransaction($invoice->id, 'other/cash');
            }
        }

        return redirect("/invoices/$invoice->id");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoiceToDelete = $invoice;
        $invoice->delete();

        return back();
    }

    protected function validator(array $data)
    {

        // validate the data then return it to the store funtion
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'email' => ['email', 'nullable'],
            'hours' => ['numeric', 'nullable'],
            'rate' => ['numeric', 'nullable'],
            'price' => ['numeric', 'nullable'],
            'paid' => ['string', 'nullable'],
            'itemized' => ['nullable']
        ]);
    }

     protected function itemValidator(array $data)
    {

        // validate the data then return it to the store funtion
        return Validator::make($data, [
            'item-hours' => ['numeric', 'required'],
            'item-desc' => ['string', 'required']
        ]);
    }

    private function convert($data) {
        // mutate just validated data

        // give value to non-entered text fields as null and numbers to float
        $data2 = [ 'hours', 'rate', 'price' ];

        foreach ($data2 as $key) {
            if (isset($data[$key]) && is_numeric($data[$key])) {
                $data[$key] = $data[$key] * 1.0;
            }
        }


        // convert paid checkbox value to boolean
        $data['paid'] = isset($data['paid']) ? true : false;
       

        // calculate the price if it's left empty
        if (empty($data['price']) && !empty($data['hours']) && !empty($data['rate'])) {
            $data['price'] = $data['hours'] * $data['rate'];
        }

        return $data;
    }


    private function randId() {
        // Function turns the id into a random number
        $randId = rand(10000,99999);
        // Make sure we never get a duplicate id
        for ( ; \App\Invoice::find($randId) != null ; ) {
            $randId = rand(10000,99999);
        }
        
        return $randId;
    }

    private function calc_itemized_hours(Array $arr) {
        $hours = 0;
        // if there is only one item, set that as the total hours, else add them all up *note return float
        if (count($arr) == 2) {
            return $arr[1]['item-hours'] * 1.0;
        } else {
            for ($i = 1; $i < count($arr); $i++) {
                $hours += ($arr[$i]['item-hours'] * 1.0);
            }
        }

        return $hours;
    }

    private function isItemized($invoice) {
        // this function is to be used before sending an $itemized variable to the view with compact

        if (isset($invoice->itemized)) {
            $itemized = $invoice->itemized;

            return (isset($itemized[1])) ? $itemized : ['no_items']; // check to see if there are items note: that index 0 is not an item
        } else {
           return null; // set to null so that compact does not through error
        }
    }

    private function calcNewItemizedHoursAndPrice(Invoice $invoice, $itemized) {
        // for itemized invoices calculates new total hours and price, set to invoice

        // calculate the new total hours
        $newHours = $this->calc_itemized_hours($itemized);
        $invoice->hours = $newHours;
        
        // calculate new total price
        $invoice->price = $invoice->rate * $newHours;
    }

    public function existsInvoice(Request $request) {

        $invoiceId = $request->input('invoice');
        if (Invoice::find($invoiceId)) {

            return redirect('/invoices/' . $invoiceId);
        } else {

            return back()->withErrors(['invoice' => 'Invoice number not found.']);
        }
    }

    public function mail(Invoice $invoice) {
        // send invoice notification email to the customer

        mail::send(new \App\Mail\NewInvoice($invoice));

        return back()->with('status','Email sent!');
    }
}