<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class GatewayController extends Controller
{
    
    public function paypal_ipn(Request $request)
	{
		$item_number = $request->item_number;
		$amount = $request->mc_gross;
		
		$invoice = \App\Invoice::where("id",$item_number)->first();
		
		if( ($invoice->total-$invoice->paid) < $amount ){

			$studentpayment= new \App\StudentPayment();
			$studentpayment->invoice_id = $item_number;
			$studentpayment->date = date("Y-m-d");
			$studentpayment->amount = $invoice->total - $invoice->paid;
			$studentpayment->note = "Pay Using PayPal";
			$studentpayment->save();

			$in= \App\Invoice::find($item_number);
			$in->status = "Paid";
			$in->paid = $invoice->total;
			$in->save();			
		}
        
    }
	
   
}
