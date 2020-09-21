<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picklist;
use Validator;
use Illuminate\Validation\Rule;

class PicklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$type = "";
        $picklists = Picklist::all()->sortByDesc("id");
        return view('backend.administration.picklist.list',compact('picklists','type'));
    }
	
	
	public function type($type)
    {
		$type = $type;
        $picklists = Picklist::where('type', $type)->orderBy('id', 'desc')->get();
        return view('backend.administration.picklist.list',compact('picklists','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.administration.picklist.create');
		}else{
           return view('backend.administration.picklist.modal.create');
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
			'type' => 'required',
			'value' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return back()->withErrors($validator)->withInput();
			}			
		}
		
	
        $picklist = new Picklist();

	    $picklist->type = $request->input('type');
		$picklist->value = $request->input('value');
	
        $picklist->save();
        
		if(! $request->ajax()){
           return back()->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$picklist]);
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
        $picklist = Picklist::find($id);
		if(! $request->ajax()){
		    return view('backend.administration.picklist.view',compact('picklist','id'));
		}else{
			return view('backend.administration.picklist.modal.view',compact('picklist','id'));
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
        $picklist = Picklist::find($id);
		if(! $request->ajax()){
		   return view('backend.administration.picklist.edit',compact('picklist','id'));
		}else{
           return view('backend.administration.picklist.modal.edit',compact('picklist','id'));
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
			'type' => 'required',
		    'value' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return back()->withErrors($validator)->withInput();
			}			
		}
	
        	
		
        $picklist = Picklist::find($id);
		$picklist->type = $request->input('type');
		$picklist->value = $request->input('value');
	
        $picklist->save();
		
		if(! $request->ajax()){
           return back()->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$picklist]);
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
        $picklist = Picklist::find($id);
        $picklist->delete();
        return back()->with('success',_lang('Information has been deleted sucessfully'));
    }
}
