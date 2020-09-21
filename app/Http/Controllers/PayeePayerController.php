<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayeePayer;
use Validator;
use Illuminate\Validation\Rule;

class PayeePayerController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payeepayers=PayeePayer::all()->sortByDesc("id");
        return view('backend.accounting.payee_payer.list',compact('payeepayers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.accounting.payee_payer.create');
		}else{
           return view('backend.accounting.payee_payer.modal.create');
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
			'name' => 'required|max:191',
		'type' => 'required|max:10',
		'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('payee_payers/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		
	    
		
        $payeepayer= new PayeePayer();
	    $payeepayer->name = $request->input('name');
	$payeepayer->type = $request->input('type');
	$payeepayer->note = $request->input('note');
	
        $payeepayer->save();
        
		if(! $request->ajax()){
           return redirect('payee_payers/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$payeepayer]);
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
        $payeepayer = PayeePayer::find($id);
		if(! $request->ajax()){
		    return view('backend.accounting.payee_payer.view',compact('payeepayer','id'));
		}else{
			return view('backend.accounting.payee_payer.modal.view',compact('payeepayer','id'));
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
        $payeepayer = PayeePayer::find($id);
		if(! $request->ajax()){
		   return view('backend.accounting.payee_payer.edit',compact('payeepayer','id'));
		}else{
           return view('backend.accounting.payee_payer.modal.edit',compact('payeepayer','id'));
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
			'name' => 'required|max:191',
		'type' => 'required|max:10',
		'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('payee_payers.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $payeepayer = PayeePayer::find($id);
		$payeepayer->name = $request->input('name');
	$payeepayer->type = $request->input('type');
	$payeepayer->note = $request->input('note');
	
        $payeepayer->save();
		
		if(! $request->ajax()){
           return redirect('payee_payers')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$payeepayer]);
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
        $payeepayer = PayeePayer::find($id);
        $payeepayer->delete();
        return redirect('payee_payers')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
