<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentGroup;
use Validator;
use Illuminate\Validation\Rule;

class StudentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentgroups=StudentGroup::all()->sortByDesc("id");
        return view('backend.administration.student_group.list',compact('studentgroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.administration.student_group.create');
		}else{
           return view('backend.administration.student_group.modal.create');
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
			'group_name' => 'required|max:100'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('student_groups/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		
	    
		
        $studentgroup= new StudentGroup();
	    $studentgroup->group_name = $request->input('group_name');
	
        $studentgroup->save();
        
		if(! $request->ajax()){
           return redirect('student_groups/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$studentgroup]);
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
        $studentgroup = StudentGroup::find($id);
		if(! $request->ajax()){
		    return view('backend.administration.student_group.view',compact('studentgroup','id'));
		}else{
			return view('backend.administration.student_group.modal.view',compact('studentgroup','id'));
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
        $studentgroup = StudentGroup::find($id);
		if(! $request->ajax()){
		   return view('backend.administration.student_group.edit',compact('studentgroup','id'));
		}else{
           return view('backend.administration.student_group.modal.edit',compact('studentgroup','id'));
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
			'group_name' => 'required|max:100'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('student_groups.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $studentgroup = StudentGroup::find($id);
		$studentgroup->group_name = $request->input('group_name');
	
        $studentgroup->save();
		
		if(! $request->ajax()){
           return redirect('student_groups')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$studentgroup]);
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
        $studentgroup = StudentGroup::find($id);
        $studentgroup->delete();
        return redirect('student_groups')->with('success',_lang('Information has been  deleted sucessfully'));
    }
}
