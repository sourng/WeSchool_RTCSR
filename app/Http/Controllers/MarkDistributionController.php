<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MarkDistribution;
use Validator;
use Illuminate\Validation\Rule;

class MarkDistributionController extends Controller
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
        $markdistributions=MarkDistribution::all();
        return view('backend.marks.mark_distribution.list',compact('markdistributions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.marks.mark_distribution.create');
		}else{
           return view('backend.marks.mark_distribution.modal.create');
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
			'mark_distribution_type' => 'required|max:50',
		    'mark_percentage' => 'required|numeric'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('mark_distributions/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		
        $markdistribution= new MarkDistribution();
	    $markdistribution->mark_distribution_type = $request->input('mark_distribution_type');
		$markdistribution->mark_percentage = $request->input('mark_percentage');
		$markdistribution->is_active = $request->input('is_active') != "" ? $request->input('is_active') : "yes";
	
        $markdistribution->save();
        
		if(! $request->ajax()){
           return redirect('mark_distributions/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$markdistribution]);
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
        $markdistribution = MarkDistribution::find($id);
		if(! $request->ajax()){
		    return view('backend.marks.mark_distribution.view',compact('markdistribution','id'));
		}else{
			return view('backend.marks.mark_distribution.modal.view',compact('markdistribution','id'));
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
        $markdistribution = MarkDistribution::find($id);
		if(! $request->ajax()){
		   return view('backend.marks.mark_distribution.edit',compact('markdistribution','id'));
		}else{
           return view('backend.marks.mark_distribution.modal.edit',compact('markdistribution','id'));
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
			'mark_distribution_type' => 'required|max:50',
		    'mark_percentage' => 'required|numeric'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('mark_distributions.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        $markdistribution = MarkDistribution::find($id);
		//$markdistribution->mark_distribution_type = $request->input('mark_distribution_type');
		$markdistribution->mark_percentage = $request->input('mark_percentage');
	    $markdistribution->is_active = $request->input('is_active')!= "" ? $request->input('is_active') : "yes";
	
        $markdistribution->save();
		
		if(! $request->ajax()){
           return redirect('mark_distributions')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$markdistribution]);
		}
	    
    }
}
