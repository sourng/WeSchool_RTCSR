<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Validator;
use Illuminate\Validation\Rule;
use Auth;

class AccountController extends Controller
{
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts=Account::all()->sortByDesc("id");
        return view('backend.accounting.bank_cash_account.list',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.accounting.bank_cash_account.create');
		}else{
           return view('backend.accounting.bank_cash_account.modal.create');
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
			'account_name' => 'required|max:50',
			'opening_balance' => 'required|numeric',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('accounts/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		

        $account= new Account();
	    $account->account_name = $request->input('account_name');
		$account->opening_balance = $request->input('opening_balance');
		$account->note = $request->input('note');
		$account->create_user_id = Auth::user()->id;
	
        $account->save();
        
		if(! $request->ajax()){
           return redirect('accounts/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$account]);
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
        $account = Account::find($id);
		if(! $request->ajax()){
		    return view('backend.accounting.bank_cash_account.view',compact('account','id'));
		}else{
			return view('backend.accounting.bank_cash_account.modal.view',compact('account','id'));
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
        $account = Account::find($id);
		if(! $request->ajax()){
		   return view('backend.accounting.bank_cash_account.edit',compact('account','id'));
		}else{
           return view('backend.accounting.bank_cash_account.modal.edit',compact('account','id'));
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
			'account_name' => 'required|max:50',
			'opening_balance' => 'required|numeric',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('accounts.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $account = Account::find($id);
		$account->account_name = $request->input('account_name');
		$account->opening_balance = $request->input('opening_balance');
		$account->note = $request->input('note');
		$account->update_user_id = Auth::user()->id;
	
        $account->save();
		
		if(! $request->ajax()){
           return redirect('accounts')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$account]);
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
        $account = Account::find($id);
        $account->delete();
        return redirect('accounts')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
