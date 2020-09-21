<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FeeType;
use Validator;
use Illuminate\Validation\Rule;

class FeeTypeController extends Controller
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
        $feetypes=FeeType::all()->sortByDesc("id");
        return view('backend.fees.fee_type.list',compact('feetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.fees.fee_type.create');
		}else{
           return view('backend.fees.fee_type.modal.create');
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
			'fee_type' => 'required|max:50',
			'fee_code' => 'required|max:20|unique:fee_types',
			'note' => 'nullable|max:191'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('fee_types/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		
	    
		
        $feetype= new FeeType();
	    $feetype->fee_type = $request->input('fee_type');
		$feetype->fee_code = $request->input('fee_code');
		$feetype->note = $request->input('note');
	
        $feetype->save();
        
		if(! $request->ajax()){
           return redirect('fee_types/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$feetype]);
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
        $feetype = FeeType::find($id);
		if(! $request->ajax()){
		    return view('backend.fees.fee_type.view',compact('feetype','id'));
		}else{
			return view('backend.fees.fee_type.modal.view',compact('feetype','id'));
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
        $feetype = FeeType::find($id);
		if(! $request->ajax()){
		   return view('backend.fees.fee_type.edit',compact('feetype','id'));
		}else{
           return view('backend.fees.fee_type.modal.edit',compact('feetype','id'));
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
			'fee_type' => 'required|max:50',
			'fee_code' => [
                'required',
                Rule::unique('fee_types')->ignore($id),
            ],
			'note' => 'nullable|max:191'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('fee_types.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $feetype = FeeType::find($id);
		$feetype->fee_type = $request->input('fee_type');
		$feetype->fee_code = $request->input('fee_code');
		$feetype->note = $request->input('note');
	
        $feetype->save();
		
		if(! $request->ajax()){
           return redirect('fee_types')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$feetype]);
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
        $feetype = FeeType::find($id);
        $feetype->delete();
        return redirect('fee_types')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
