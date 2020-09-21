<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class TeacherController extends Controller
{

    public function my_profile()
    {
		$teacher = \App\Teacher::select('*','teachers.id AS id')
                            ->join('users','users.id','=','teachers.user_id')
                            ->where('teachers.id',get_teacher_id())
                            ->first();
        return view('backend.private.teacher.profile',compact('teacher'));	
    }
	
	public function class_schedule()
    {
		$routine = \App\ClassRoutine::getTeacherRoutine(get_teacher_id());
		return view('backend.private.teacher.class_schedule',compact('routine'));	
    }
	
	public function mark_register()
    {
		$data = array();
		$data['class_id'] = 0;
		$data['section_id'] = 0;
		return view('backend.private.teacher.mark_register',$data);	
    }
	
	public function create_mark(Request $request)
    {	
	    $exam = $request->input('exam');
		$class_id = $request->input('class_id');
		$section_id = $request->input('section_id');
		$subject_id = $request->input('subject_id');
		$marks =[];
		$mark_destributions =[];
		$new_fields = [];
		
		if( $exam != "" && $class_id != "" && $section_id != "" && $subject_id != "" ){
				$marks = \App\Student::select('*','marks.id as mark_id')
					   ->leftJoin('marks',function($join) use ($exam, $class_id, $subject_id, $section_id) {
							$join->on('marks.student_id','=','students.id');
							$join->where('marks.exam_id','=',$exam);
							$join->where('marks.subject_id','=',$subject_id);
							$join->where('marks.class_id','=',$class_id);
							$join->where('marks.section_id','=',$section_id);
						})
						->join('student_sessions','student_sessions.student_id','=','students.id')
						->where('student_sessions.class_id',$class_id)
						->where('student_sessions.section_id',$section_id)
						->orderBy('student_sessions.roll', 'ASC')
						->get();
						
			$mark_destributions = \App\MarkDistribution::where("is_active","=","yes")->get();
			
			$existing_marks = DB::select("SELECT mark_distributions.*, mark_details.* from mark_distributions 
			LEFT JOIN mark_details ON mark_details.mark_type = mark_distributions.mark_distribution_type AND mark_details.mark_id IN 
			(SELECT id FROM marks WHERE class_id=:class AND section_id=:section AND subject_id=:subject AND exam_id=:exam) 
			WHERE mark_distributions.is_active='yes'", ["class"=>$class_id, "section"=>$section_id, "subject"=>$subject_id, "exam"=>$exam]);
			
			$new_fields = DB::select("SELECT mark_distributions.*, mark_details.* from mark_distributions LEFT JOIN mark_details 
			ON mark_details.mark_type = mark_distributions.mark_distribution_type AND mark_details.mark_id IN 
			(SELECT id FROM marks WHERE class_id=:class AND section_id=:section AND subject_id=:subject AND exam_id=:exam) 
			WHERE mark_distributions.is_active='yes' and mark_details.mark_id IS NULL", 
			["class"=>$class_id, "section"=>$section_id, "subject"=>$subject_id, "exam"=>$exam]);
			
			
			$mark_details = [];
			
			foreach($existing_marks as $key=>$val){
				if($val->mark_id != ""){
				   $mark_details[$val->mark_id][$val->mark_type] = $val;
				}
			}
		}	
	    return view('backend.private.teacher.mark_register',compact('mark_details', 'mark_destributions', 'new_fields', 'marks', 'exam', 'class_id', 'section_id', 'subject_id'));
        
	}
	
	public function store_mark(Request $request)
    {		
        for ($i=0; $i < count($request->student_id) ; $i++) {
			$temp = array();
			$temp['exam_id'] = (int)$request->exam_id[$i];
			$temp['subject_id'] = (int)$request->subject_id[$i];
			$temp['student_id'] = (int)$request->student_id[$i];
			$temp['class_id'] = (int)$request->class_id[$i];
			$temp['section_id'] = (int)$request->section_id[$i];		
			
			$marks = \App\Mark::firstOrNew($temp);
			$marks->exam_id = $temp['exam_id'];
			$marks->subject_id = $temp['subject_id'];
			$marks->student_id = $temp['student_id'];
			$marks->class_id = $temp['class_id'];
			$marks->section_id = $temp['section_id'];
			$marks->save();	
			
			//Store Mark Details
			foreach($request->marks as $key=>$value){

                $temp2 = array();
				$temp2['mark_id'] = $marks->id;
				$temp2['mark_type'] = $key;
		
				$marksDt = \App\MarkDetails::firstOrNew($temp2);
				$marksDt->mark_id = $marks->id;
				$marksDt->mark_type = $key;
				$marksDt->mark_value = $value[$temp['student_id']];
				$marksDt->save();	
			}		
        }


		if(! $request->ajax()){
		   return redirect('teacher/marks/create')->with('success',_lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully')]);
		}
   }
   
   public function assignments(){
		$assignments = \App\Assignment::select('*','assignments.id AS id')
                            ->join('classes','classes.id','=','assignments.class_id')
                            ->join('sections','sections.id','=','assignments.class_id')
                            ->join('subjects','subjects.id','=','assignments.class_id')
							->join('assign_subjects','subjects.id','=','assign_subjects.subject_id')
                            ->where('assign_subjects.teacher_id', get_teacher_id())
                            ->where('assignments.session_id', get_option('academic_year'))
                            ->orderBy('assignments.id', 'DESC')
							->groupBy('assignments.id')
                            ->get();
        return view('backend.private.teacher.assignments.assignment-list',compact('assignments'));
   }   
   
   public function create_assignment()
   {
       return view('backend.private.teacher.assignments.assignment-add');
   }
   
   public function store_assignment(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'file' => 'required',
            'file_2' => 'nullable',
            'file_3' => 'nullable',
            'file_4' => 'nullable',
        ]);

        $assignment = new \App\Assignment();
        $assignment->session_id = get_option("academic_year");
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->deadline = $request->deadline;
        $assignment->class_id = $request->class_id;
        $assignment->section_id = $request->section_id;
        $assignment->subject_id = $request->subject_id;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file = $file_name;
        }
        if($request->hasFile('file_2')){
            $file = $request->file('file_2');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_2 = $file_name;
        }
        if($request->hasFile('file_3')){
            $file = $request->file('file_3');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_3 = $file_name;
        }
        if($request->hasFile('file_4')){
            $file = $request->file('file_4');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_4 = $file_name;
        }

        $assignment->save();

        return redirect('teacher/assignments')->with('success', _lang('Information has been added'));
    }
	
	public function edit_assignment($id)
    {
        $assignment = \App\Assignment::where("id",$id)
		                        ->where('assignments.session_id', get_option('academic_year'))->first();

        return view('backend.private.teacher.assignments.assignment-edit',compact('assignment'));
    }
	
	
	public function show_assignment($id)
    {
        $assignment = \App\Assignment::select('*','assignments.id AS id')
                            ->join('classes','classes.id','=','assignments.class_id')
                            ->join('sections','sections.id','=','assignments.class_id')
                            ->join('subjects','subjects.id','=','assignments.class_id')
                            ->where('assignments.id',$id)
							->where('assignments.session_id', get_option('academic_year'))
                            ->first();

        return view('backend.assignments.assignment-show',compact('assignment'));
    }


    public function update_assignment(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'file' => 'nullable',
            'file_2' => 'nullable',
            'file_3' => 'nullable',
            'file_4' => 'nullable',
        ]);

        $assignment = \App\Assignment::find($id);
		$assignment->session_id = get_option("academic_year");
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->deadline = $request->deadline;
        $assignment->class_id = $request->class_id;
        $assignment->section_id = $request->section_id;
        $assignment->subject_id = $request->subject_id;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file = $file_name;
        }
        if($request->hasFile('file_2')){
            $file = $request->file('file_2');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_2 = $file_name;
        }
        if($request->hasFile('file_3')){
            $file = $request->file('file_3');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_3 = $file_name;
        }
        if($request->hasFile('file_4')){
            $file = $request->file('file_4');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_4 = $file_name;
        }

        $assignment->save();

        return redirect('teacher/assignments')->with('success', _lang('Information has been updated'));
    }

    public function destroy_assignment($id)
    {
        $assignment = \App\Assignment::find($id);
        $assignment->delete();

        return redirect('teacher/assignments')->with('success', _lang('Information has been deleted'));
    }
	
	 
}
