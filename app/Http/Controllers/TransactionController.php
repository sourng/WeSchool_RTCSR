<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Validator;
use Illuminate\Validation\Rule;
use Auth;

class TransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function income()
    {
        $transactions = Transaction::select('transactions.*','chart_of_accounts.name as c_type','bank_cash_accounts.account_name',
						'payee_payers.name as payee_payer','payment_methods.name as payment_method','transactions.id as id')
		                ->join("bank_cash_accounts","bank_cash_accounts.id","=","transactions.account_id")
		                ->join("chart_of_accounts","chart_of_accounts.id","=","transactions.chart_id")
		                ->leftjoin("payment_methods","payment_methods.id","=","transactions.payment_method_id")
		                ->leftjoin("payee_payers","payee_payers.id","=","transactions.payee_payer_id")
		                ->where("transactions.trans_type","income")
						->orderBy("transactions.id","DESC")->get();
        return view('backend.accounting.transaction.income.list',compact('transactions'));
    }
	
	public function expense()
    {
        $transactions = Transaction::select('transactions.*','chart_of_accounts.name as c_type','bank_cash_accounts.account_name',
						'payee_payers.name as payee_payer','payment_methods.name as payment_method','transactions.id as id')
		                ->join("bank_cash_accounts","bank_cash_accounts.id","=","transactions.account_id")
		                ->join("chart_of_accounts","chart_of_accounts.id","=","transactions.chart_id")
		                ->leftjoin("payment_methods","payment_methods.id","=","transactions.payment_method_id")
		                ->leftjoin("payee_payers","payee_payers.id","=","transactions.payee_payer_id")
		                ->where("transactions.trans_type","expense")
						->orderBy("transactions.id","DESC")->get();
        return view('backend.accounting.transaction.expense.list',compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_income(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.accounting.transaction.income.create');
		}else{
           return view('backend.accounting.transaction.income.modal.create');
		}
    }
	
	public function add_expense(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.accounting.transaction.expense.create');
		}else{
           return view('backend.accounting.transaction.expense.modal.create');
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
			'trans_date' => 'required',
			'account_id' => 'required',
			'chart_id' => 'required',
			'amount' => 'required|numeric',
			'attachment' => 'nullable|mimes:jpeg,png,jpg,doc,pdf,docx,zip',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('transactions/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		$attachment = "";
	    if($request->hasfile('attachment'))
		{
		  $file = $request->file('attachment');
		  $attachment = time().$file->getClientOriginalName();
		  $file->move(public_path()."/uploads/transactions/", $attachment);
		}
		
        $transaction= new Transaction();
	    $transaction->trans_date = $request->input('trans_date');
		$transaction->account_id = $request->input('account_id');
		$transaction->trans_type = $request->input('trans_type');
		$transaction->amount = $request->input('amount');
		$transaction->dr_cr = $request->input('dr_cr');
		$transaction->chart_id = $request->input('chart_id');
		$transaction->payee_payer_id = $request->input('payee_payer_id');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->create_user_id = Auth::user()->id;
		$transaction->reference = $request->input('reference');
		$transaction->attachment = $attachment;
		$transaction->note = $request->input('note');
	
        $transaction->save();
        
		if(! $request->ajax()){
           return redirect($_SERVER['HTTP_REFERER'])->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$transaction]);
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
        $transaction = Transaction::select('transactions.*','chart_of_accounts.name as c_type','bank_cash_accounts.account_name',
						'payee_payers.name as payee_payer','payment_methods.name as payment_method','transactions.id as id')
		                ->join("bank_cash_accounts","bank_cash_accounts.id","=","transactions.account_id")
		                ->join("chart_of_accounts","chart_of_accounts.id","=","transactions.id")
		                ->leftjoin("payment_methods","payment_methods.id","=","transactions.payment_method_id")
		                ->leftjoin("payee_payers","payee_payers.id","=","transactions.payee_payer_id")
		                ->where("transactions.id",$id)->first();
		if(! $request->ajax()){
		    return view('backend.accounting.transaction.income.view',compact('transaction','id'));
		}else{
			return view('backend.accounting.transaction.income.modal.view',compact('transaction','id'));
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
        $transaction = Transaction::find($id);
		if(! $request->ajax()){
		   return view('backend.accounting.transaction.income.edit',compact('transaction','id'));
		}else{
           return view('backend.accounting.transaction.income.modal.edit',compact('transaction','id'));
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
			'trans_date' => 'required',
			'account_id' => 'required',
			'chart_id' => 'required',
			'amount' => 'required|numeric',
			'attachment' => 'nullable|mimes:jpeg,png,jpg,doc,pdf,docx,zip',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('transactions.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
	    $attachment = "";
        if($request->hasfile('attachment'))
		{
		  $file = $request->file('attachment');
		  $attachment = time().$file->getClientOriginalName();
		  $file->move(public_path()."/uploads/transactions/", $attachment);
		}	
		
        $transaction = Transaction::find($id);
		$transaction->trans_date = $request->input('trans_date');
		$transaction->account_id = $request->input('account_id');
		$transaction->trans_type = $request->input('trans_type');
		$transaction->amount = $request->input('amount');
		$transaction->dr_cr = $request->input('dr_cr');
		$transaction->chart_id = $request->input('chart_id');
		$transaction->payee_payer_id = $request->input('payee_payer_id');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->update_user_id = Auth::user()->id;
		$transaction->reference = $request->input('reference');
		if($request->hasfile('attachment')){
			$transaction->attachment = $attachment;
		}
		$transaction->note = $request->input('note');
	
        $transaction->save();
		
		if(! $request->ajax()){
		   if($request->input('trans_type') == "income"){	
			   return redirect('transactions/income')->with('success', _lang('Information has been updated sucessfully'));
           }else{
			   return redirect('transactions/expense')->with('success', _lang('Information has been updated sucessfully')); 
		   }
		}else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$transaction]);
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
        $transaction = Transaction::find($id);
        $transaction->delete();
        return redirect('transactions')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
