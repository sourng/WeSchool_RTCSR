<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentPayment;
use App\Invoice;
use Validator;
use Illuminate\Validation\Rule;

class StudentPaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class="")
    {
		$studentpayments = array();
		if($class !="" ){
			$studentpayments = StudentPayment::join('invoices','invoices.id','=','student_payments.invoice_id')
									->select('invoices.*','student_payments.*','student_payments.id as id')						
									->where('invoices.session_id',get_option('academic_year'))
									->where('invoices.class_id',$class)
									->orderBy('student_payments.id', 'DESC')
									->get();
        }								
        return view('backend.student_payment.list',compact('studentpayments','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $invoice_id = "")
    {   
	    $invoice = Invoice::find($invoice_id);
	    $history = StudentPayment::where("invoice_id",$invoice_id)->get();
		if( ! $request->ajax()){
		   return view('backend.student_payment.create',compact('invoice_id','invoice','history'));
		}else{
           return view('backend.student_payment.modal.create',compact('invoice_id','invoice','history'));
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
		$validator = Validator::make($request->all(), [
			'invoice_id' => 'required',
			'date' => 'required',
			'amount' => 'required|numeric'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('student_payments/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		

        $studentpayment= new StudentPayment();
	    $studentpayment->invoice_id = $request->input('invoice_id');
		$studentpayment->date = $request->input('date');
		$studentpayment->amount = $request->input('amount');
		$studentpayment->note = $request->input('note');
	
        $studentpayment->save();
		
		
		//Update Invoice
		$invoice = Invoice::find($studentpayment->invoice_id);		
		if(($invoice->paid + $studentpayment->amount) >= $invoice->total){
			$invoice->status = "Paid";
		}
		$invoice->paid = $invoice->paid + $studentpayment->amount;
        $invoice->save();
		
		if(! $request->ajax()){
           return redirect('student_payments/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store2','message'=>_lang('Information has been added sucessfully'),'data'=>$studentpayment]);
		}
        
   }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $studentpayment = StudentPayment::find($id);
		if(! $request->ajax()){
		    return view('backend.student_payment.view',compact('studentpayment','id'));
		}else{
			return view('backend.student_payment.modal.view',compact('studentpayment','id'));
		} 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $studentpayment = StudentPayment::find($id);
	    $history = StudentPayment::where("invoice_id",$studentpayment->invoice_id)->get();
		if(! $request->ajax()){
		   return view('backend.student_payment.edit',compact('studentpayment','id','history'));
		}else{
           return view('backend.student_payment.modal.edit',compact('studentpayment','id','history'));
		}         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	
		$validator = Validator::make($request->all(), [
			'invoice_id' => 'required',
			'date' => 'required',
			'amount' => 'required|numeric'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('student_payments.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
        $studentpayment = StudentPayment::find($id);
		$previous_amount = $studentpayment->amount;
		$studentpayment->invoice_id = $request->input('invoice_id');
		$studentpayment->date = $request->input('date');
		$studentpayment->amount = $request->input('amount');
		$studentpayment->note = $request->input('note');
	
        $studentpayment->save();
		
		//Update Invoice
		$invoice = Invoice::find($studentpayment->invoice_id);		
		if((($invoice->paid + $studentpayment->amount) - $previous_amount) >= $invoice->total){
			$invoice->status = "Paid";
		}else{
			$invoice->status = "Unpaid";
		}
		$invoice->paid = (($invoice->paid + $studentpayment->amount) - $previous_amount);
        $invoice->save();
		
		if(! $request->ajax()){
           return redirect('student_payments')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$studentpayment]);
		}
	    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentpayment = StudentPayment::find($id);
        $studentpayment->delete();
        return redirect('student_payments')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
