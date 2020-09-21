<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClassRoutine;
use App\ClassModel;
use App\Section;
use Carbon\Carbon;

class ClassRoutineController extends Controller
{
  
    public function index()
    {
	    $class="";
	    $routine_list = ClassRoutine::RoutineList();
	    return view('backend.class_routine.routine_list',compact('routine_list','class'));    
    }
	
	
	public function class($class_id = "")
    {
		$class = sql_escape($class_id);
        $routine_list = ClassRoutine::RoutineList($class_id);
	    return view('backend.class_routine.routine_list',compact('routine_list','class'));
    }
	
	
    public function manage($class_id = "", $section_id = "")
    {
		$data = array();
        $data['class'] = ClassModel::find($class_id);
        $data['section'] = Section::find($section_id);
        $data['routine'] = ClassRoutine::getRoutine($class_id, $section_id);
		
		return view('backend.class_routine.routine_add',$data);
    }
	
	public function store(Request $request)
    {
        $len = count($request->subject_id);
		$insertdata = array();
		$updatedata = array();
		
		for($i = 0; $i<$len; $i++){
			if($request->routine_id[$i] == ""){
				$temp = array();
				$temp['section_id'] = $request->section_id[$i];
				$temp['subject_id'] = $request->subject_id[$i];
				$temp['day'] = $request->day[$i];
				$temp['start_time'] = $request->start_time[$i];
				$temp['end_time'] = $request->end_time[$i];
				$temp['created_at'] = Carbon::now();
				$temp['updated_at'] = Carbon::now();
				
				if($request->start_time[$i]){
				   array_push($insertdata,$temp);
				}
			}else{
				$temp = array();
				$temp['section_id'] = $request->section_id[$i];
				$temp['subject_id'] = $request->subject_id[$i];
				$temp['day'] = $request->day[$i];
				$temp['start_time'] = $request->start_time[$i];
				$temp['end_time'] = $request->end_time[$i];
				$temp['updated_at'] = Carbon::now();
				array_push($updatedata,$temp);
			}
        }			
		
		//Insert
		if(! empty($insertdata) ){
			ClassRoutine::insert($insertdata);
		}
		
		//Update 
		foreach($updatedata as $d){
		   ClassRoutine::where('subject_id','=',$d['subject_id'])
		   ->where('section_id','=',$d['section_id'])
		   ->where('day','=',$d['day'])
		   ->update($d);
		}
		
		return response()->json(['result'=>'success','message'=>_lang('Saved Sucessfully')]);
      
	}
	
	public function show($class_id = "", $section_id = ""){
		$data = array();
        $data['class'] = ClassModel::find($class_id);
        $data['section'] = Section::find($section_id);
        $data['routine'] = ClassRoutine::getRoutineView($class_id, $section_id);
		
		return view('backend.class_routine.routine_view',$data);
	}
	
}