<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use App\Student;
use App\Subject;
use App\ExamSchedule;
use App\ExamAttendance;
use Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ExamController extends Controller
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
        $exams = Exam::where("session_id",get_option("academic_year"))
		->orderBy('id', 'desc')
		->get();
        return view('backend.exam.exam.list',compact('exams'));
    }
	
	public function exam_schedule($type='view', Request $request){
		
		// dd($request->all());
		$exam = $request->input('exam');
		$class = $request->input('class');
		$footer_sign=$request->input('footer_sign');
		$type = $type;
		
		if($exam !="" && $class !=""){
			$subjects = Subject::select('*','exam_schedules.id as schedules_id','subjects.id as subject_id')
			            ->leftJoin('exam_schedules',function($join) use ($exam) {
							$join->on('subjects.id', '=', 'exam_schedules.subject_id');
							$join->where('exam_schedules.exam_id',$exam);
						})
						->where('subjects.class_id',$class)
			            ->get();
			return view('backend.exam.schedule.create',compact('subjects','class','exam','type','footer_sign'));
		}else{		
			return view('backend.exam.schedule.create',compact('class','exam','type','footer_sign'));
		}
	}
	
	public function store_exam_schedule(Request $request){
		$len = count($request->subject_id);
		$insertdata = array();
		$updatedata = array();
		
		for($i = 0; $i<$len; $i++){
			if($request->schedules_id[$i] == ""){
				$temp = array();
				$temp['exam_id'] = $request->exam_id[$i];
				$temp['class_id'] = $request->class_id[$i];
				$temp['subject_id'] = $request->subject_id[$i];
				$temp['date'] = $request->date[$i];
				$temp['start_time'] = $request->start_time[$i];
				$temp['end_time'] = $request->end_time[$i];
				$temp['room'] = $request->room[$i];
				$temp['created_at'] = Carbon::now();
				$temp['updated_at'] = Carbon::now();

				array_push($insertdata,$temp);
				
			}else{
				$temp = array();
				$temp['exam_id'] = $request->exam_id[$i];
				$temp['class_id'] = $request->class_id[$i];
				$temp['subject_id'] = $request->subject_id[$i];
				$temp['date'] = $request->date[$i];
				$temp['start_time'] = $request->start_time[$i];
				$temp['end_time'] = $request->end_time[$i];
				$temp['room'] = $request->room[$i];
				$temp['updated_at'] = Carbon::now();
				
				array_push($updatedata,$temp);
			}
        }			
		
		//Insert
		if(! empty($insertdata) ){
			ExamSchedule::insert($insertdata);
		}
		
		//Update 
		foreach($updatedata as $d){
		   ExamSchedule::where('subject_id','=',$d['subject_id'])
		   ->where('exam_id','=',$d['exam_id'])
		   ->where('class_id','=',$d['class_id'])
		   ->update($d);
		}
		
		if(! $request->ajax()){
		   return redirect('exams/schedule/create')->with('success',_lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully')]);
		}
		//return response()->json(['result'=>'success','message'=>_lang('Saved Sucessfully')]);
      
	}
	
	public function exam_attendance(Request $request){
		$exam = $request->input('exam');
		$class_id = $request->input('class_id');
		$section_id = $request->input('section_id');
		$subject_id = $request->input('subject_id');

		if( $exam != "" && $class_id != "" && $section_id != "" && $subject_id != "" ){
			
			$attendance = Student::select('*','exam_attendances.id AS attendance_id')
						->leftJoin('exam_attendances',function($join) use ($exam, $subject_id, $section_id) {
							$join->on('exam_attendances.student_id','=','students.id');
							$join->where('exam_attendances.exam_id','=',$exam);
							$join->where('exam_attendances.subject_id','=',$subject_id);
							$join->where('exam_attendances.section_id','=',$section_id);
						})
						->join('student_sessions','student_sessions.student_id','=','students.id')
						->where('student_sessions.class_id',$class_id)
						->where('student_sessions.section_id',$section_id)
						->orderBy('student_sessions.roll', 'ASC')
						->get();			
			return view('backend.exam.attendance.attendance',compact('attendance','class_id','section_id','exam','subject_id'));
		
		}else{		
			return view('backend.exam.attendance.attendance',compact('class_id','section_id','exam','subject_id'));
		}
	}
	
	public function store_exam_attendance(Request $request)
    {		
		$validator = Validator::make($request->all(), [
            'attendance' => 'required',
        ]);
        if ($validator->fails()) {
            
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('exams/attendance')
                            ->withErrors($validator)
                            ->withInput();
			}				
        }
		
        for ($i=0; $i < count($request->student_id) ; $i++) {
			$temp = array();
			$temp['exam_id'] = (int)$request->exam_id[$i];
			$temp['subject_id'] = (int)$request->subject_id[$i];
			$temp['student_id'] = (int)$request->student_id[$i];
			$temp['class_id'] = (int)$request->class_id[$i];
			$temp['section_id'] = (int)$request->section_id[$i];
			$temp['date'] = $request->date;
			
			$studentAtt = ExamAttendance::firstOrNew($temp);
			$studentAtt->exam_id = $temp['exam_id'];
			$studentAtt->subject_id = $temp['subject_id'];
			$studentAtt->student_id = $temp['student_id'];
			$studentAtt->class_id = $temp['class_id'];
			$studentAtt->section_id = $temp['section_id'];
			$studentAtt->date = $temp['date'];
			$studentAtt->attendance = isset($request->attendance[$i]) ? $request->attendance[$i][0] : 0;
			$studentAtt->save();				
        }


		if(! $request->ajax()){
		   return redirect('/exams/attendance')->with('success',_lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully')]);
		}

    }
	
	
	
	public function get_exam(Request $request){
		$results = Exam::select('exams.*')
		           ->join('exam_schedules','exam_schedules.exam_id','=','exams.id')
		           ->where('exam_schedules.subject_id',$request->subject_id)
		           ->where('exams.session_id',get_option('academic_year'))
		           ->orderBy('exams.id', 'DESC')->get();
        $sections = '';
        $sections .= '<option value="">'._lang('Select One').'</option>';
        foreach($results as $data){
            $sections .= '<option value="'.$data->id.'">'.$data->name.'</option>';
        }
        return $sections;
	}
	
	public function get_subject(Request $request){
		$results = Subject::where("class_id",$request->class_id)->get();
        $sections = '';
        $sections .= '<option value="">'._lang('Select One').'</option>';
        foreach($results as $data){
            $sections .= '<option value="'.$data->id.'">'.$data->subject_name.'</option>';
        }
        return $sections;
	}
	
	public function get_teacher_subject(Request $request){
		$results = Subject::join("assign_subjects","subjects.id","assign_subjects.subject_id")
						   ->select('subjects.*')
						   ->where("assign_subjects.teacher_id",get_teacher_id())
						   ->where("assign_subjects.section_id",$request->section_id)
						   ->where("subjects.class_id",$request->class_id)->get();
        
		$sections = '';
        $sections .= '<option value="">'._lang('Select One').'</option>';
        foreach($results as $data){
            $sections .= '<option value="'.$data->id.'">'.$data->subject_name.'</option>';
        }
        return $sections;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.exam.exam.create');
		}else{
           return view('backend.exam.exam.modal.create');
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
			'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('exams/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
        $exam= new Exam();
	    $exam->name = $request->input('name');
		$exam->note = $request->input('note');
		$exam->session_id = get_option('academic_year');
	
        $exam->save();
        
		if(! $request->ajax()){
           return redirect('exams/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$exam]);
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
        $exam = Exam::find($id);
		if(! $request->ajax()){
		    return view('backend.exam.exam.view',compact('exam','id'));
		}else{
			return view('backend.exam.exam.modal.view',compact('exam','id'));
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
        $exam = Exam::find($id);
		if(! $request->ajax()){
		   return view('backend.exam.exam.edit',compact('exam','id'));
		}else{
           return view('backend.exam.exam.modal.edit',compact('exam','id'));
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
			'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('exams.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}

        $exam = Exam::find($id);
		$exam->name = $request->input('name');
		$exam->note = $request->input('note');
		$exam->session_id = get_option('academic_year');
	
        $exam->save();
		
		if(! $request->ajax()){
           return redirect('exams')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$exam]);
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
        $exam = Exam::find($id);
        $exam->delete();
        return redirect('exams')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
