<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grade;
use Validator;
use Illuminate\Validation\Rule;

class GradeController extends Controller
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
        $grades=Grade::all()->sortByDesc("id");
        return view('backend.marks.grade.list',compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.marks.grade.create');
		}else{
           return view('backend.marks.grade.modal.create');
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
		'grade_name' => 'required|max:20',
		'marks_from' => 'required|numeric',
		'marks_to' => 'required|numeric',
		'point' => 'required|numeric',
		'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('grades/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		
	    
		
        $grade= new Grade();
	    $grade->grade_name = $request->input('grade_name');
		$grade->marks_from = $request->input('marks_from');
		$grade->marks_to = $request->input('marks_to');
		$grade->point = $request->input('point');
		$grade->note = $request->input('note');
	
        $grade->save();
        
		if(! $request->ajax()){
           return redirect('grades/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$grade]);
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
        $grade = Grade::find($id);
		if(! $request->ajax()){
		    return view('backend.marks.grade.view',compact('grade','id'));
		}else{
			return view('backend.marks.grade.modal.view',compact('grade','id'));
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
        $grade = Grade::find($id);
		if(! $request->ajax()){
		   return view('backend.marks.grade.edit',compact('grade','id'));
		}else{
           return view('backend.marks.grade.modal.edit',compact('grade','id'));
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
		'grade_name' => 'required|max:20',
		'marks_from' => 'required|numeric',
		'marks_to' => 'required|numeric',
		'point' => 'required|numeric',
		'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('grades.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $grade = Grade::find($id);
		$grade->grade_name = $request->input('grade_name');
		$grade->marks_from = $request->input('marks_from');
		$grade->marks_to = $request->input('marks_to');
		$grade->point = $request->input('point');
		$grade->note = $request->input('note');
	
        $grade->save();
		
		if(! $request->ajax()){
           return redirect('grades')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$grade]);
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
        $grade = Grade::find($id);
        $grade->delete();
        return redirect('grades')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
