<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
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
        $events = Event::all()->sortByDesc("id");
        return view('backend.event.list',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.event.create');
		}else{
           return view('backend.event.modal.create');
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
			'start_date' => 'required',
		'end_date' => 'required',
		'name' => 'required',
		'details' => 'required',
		'location' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('events/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			
	    
		
        $event= new Event();
	    $event->start_date = $request->input('start_date');
	$event->end_date = $request->input('end_date');
	$event->name = $request->input('name');
	$event->details = $request->input('details');
	$event->location = $request->input('location');
	
        $event->save();
        
		if(! $request->ajax()){
           return redirect('events/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$event]);
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
        $event = Event::find($id);
		if(! $request->ajax()){
		    return view('backend.event.view',compact('event','id'));
		}else{
			return view('backend.event.modal.view',compact('event','id'));
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
        $event = Event::find($id);
		if(! $request->ajax()){
		   return view('backend.event.edit',compact('event','id'));
		}else{
           return view('backend.event.modal.edit',compact('event','id'));
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
			'start_date' => 'required',
		'end_date' => 'required',
		'name' => 'required',
		'details' => 'required',
		'location' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('events.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $event = Event::find($id);
		$event->start_date = $request->input('start_date');
	$event->end_date = $request->input('end_date');
	$event->name = $request->input('name');
	$event->details = $request->input('details');
	$event->location = $request->input('location');
	
        $event->save();
		
		if(! $request->ajax()){
           return redirect('events')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$event]);
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
        $event = Event::find($id);
        $event->delete();
        return redirect('events')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
