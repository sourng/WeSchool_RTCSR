<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Mark;
use App\MarkDistribution;
use App\MarkDetails;
use App\StudentSession;
use App\User;
use App\ClassModel;
use App\Section;
use App\Subject;
use App\Exam;
use Validator;
use Illuminate\Validation\Rule;
use DB;

class MarkController extends Controller
{
	
    public function index($class='')
    {
		$class = $class;
        $students = Student::join('users','users.id','=','students.user_id')
					->join('student_sessions','students.id','=','student_sessions.student_id')
					->join('classes','classes.id','=','student_sessions.class_id')
					->join('sections','sections.id','=','student_sessions.section_id')
					->select('users.*','student_sessions.roll','classes.class_name','sections.section_name','students.id as id','classes.id as class_id')						
					->where('student_sessions.session_id',get_option('academic_year'))
					->where('student_sessions.class_id',$class)
					->where('users.user_type','Student')
					->orderBy('student_sessions.roll', 'ASC')
					->get();
        return view('backend.marks.mark_list',compact('students','class'));
    }
	
	public function view_marks($student_id='',$class_id=''){
		$student = Student::join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->leftjoin('student_groups','student_groups.id','=','students.group')
                     ->join('sections','sections.id','=','student_sessions.section_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$student_id)->first();
					 
		$exams = DB::select("SELECT marks.exam_id,marks.class_id,marks.section_id,marks.subject_id, exams.name 
		FROM marks,exams WHERE marks.exam_id=exams.id AND marks.student_id=:student_id
		AND marks.class_id=:class AND exams.session_id=:session GROUP BY marks.exam_id", ["student_id" => $student_id, "class" => $class_id, "session"=>get_option('academic_year')]);    
		
		$subjects = Subject::where("class_id",$class_id)->get(); 
		
		$existing_marks = DB::select("SELECT marks.subject_id, marks.exam_id,mark_details.* from mark_details,marks,exams WHERE mark_details.mark_id=marks.id 
		AND marks.exam_id=exams.id AND marks.class_id=:class AND marks.student_id=:student AND exams.session_id=:session", ["class"=>$class_id, "student"=>$student_id, "session"=>get_option('academic_year')]);
	     
		 
		$mark_head = DB::select("SELECT distinct mark_details.mark_type from mark_distributions 
		JOIN mark_details JOIN marks ON mark_details.mark_type = mark_distributions.mark_distribution_type 
		AND mark_details.mark_id=marks.id WHERE marks.class_id=:class AND marks.student_id=:student", ["class"=>$class_id, "student"=>$student_id]);
	
	    $mark_details = [];
			
		foreach($existing_marks as $key=>$val){
			if($val->mark_id != ""){
			   $mark_details[$val->subject_id][$val->exam_id][$val->mark_type] = $val;
			}
		}
		
		//dd($mark_details);
		return view('backend.marks.view_mark',compact('exams', 'mark_head', 'mark_details', 'subjects', 'student'));
			
	}

    public function create(Request $request)
    {	
	    $exam = $request->input('exam');
		$class_id = $request->input('class_id');
		$section_id = $request->input('section_id');
		$subject_id = $request->input('subject_id');
		$marks =[];
		$mark_destributions =[];
		$new_fields = [];
		
		if( $exam != "" && $class_id != "" && $section_id != "" && $subject_id != "" ){
				$marks = Student::select('*','marks.id as mark_id')
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
						
			$mark_destributions = MarkDistribution::where("is_active","=","yes")->get();
			
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
	    return view('backend.marks.mark_register.create',compact('mark_details', 'mark_destributions', 'new_fields', 'marks', 'exam', 'class_id', 'section_id', 'subject_id'));
        
	}
	

    public function store(Request $request)
    {		
        for ($i=0; $i < count($request->student_id) ; $i++) {
			$temp = array();
			$temp['exam_id'] = (int)$request->exam_id[$i];
			$temp['subject_id'] = (int)$request->subject_id[$i];
			$temp['student_id'] = (int)$request->student_id[$i];
			$temp['class_id'] = (int)$request->class_id[$i];
			$temp['section_id'] = (int)$request->section_id[$i];		
			
			$marks = Mark::firstOrNew($temp);
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
		
				$marksDt = MarkDetails::firstOrNew($temp2);
				$marksDt->mark_id = $marks->id;
				$marksDt->mark_type = $key;
				$marksDt->mark_value = $value[$temp['student_id']];
				$marksDt->save();	
			}		
        }


		if(! $request->ajax()){
		   return redirect('/marks/create')->with('success',_lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully')]);
		}
   }
   
   public function student_ranks($class =""){
    
    $students = [];
	if($class !="" ){
	   $class_id = $class;
	   $session = get_option('academic_year');	
	   
	   $students = DB::select("SELECT marks.student_id,students.first_name,students.last_name,users.image,student_sessions.roll,classes.class_name,sections.section_name, 
	   IFNULL(SUM(mark_details.mark_value),0) as total_marks FROM marks,mark_details,exams,students,users,student_sessions,classes,sections
	   WHERE marks.id=mark_details.mark_id AND marks.exam_id=exams.id AND marks.student_id=students.id AND students.user_id=users.id AND 
	   students.id=student_sessions.student_id AND student_sessions.class_id=classes.id AND student_sessions.section_id=sections.id  
	   AND marks.class_id=:class AND exams.session_id=:session GROUP BY marks.student_id ORDER BY total_marks DESC", ["session"=>$session,"session"=>$session,"class"=>$class_id]);
	   
	   //SELECT final_marks.* FROM (SELECT marks.student_id,marks.subject_id,IFNULL(SUM(mark_details.mark_value),0) as subject_mark,(SUM(mark_details.mark_value)/(SELECT COUNT(id) FROM marks as m WHERE subject_id=marks.subject_id AND student_id='3')) avg_mark FROM mark_details,marks,exams,subjects WHERE mark_details.mark_id=marks.id AND marks.subject_id=subjects.id AND marks.exam_id=exams.id AND exams.session_id=1 AND marks.student_id='3' GROUP BY marks.subject_id) as final_marks,subjects WHERE final_marks.subject_id=subjects.id AND final_marks.avg_mark<subjects.pass_mark
	   //SELECT marks.student_id,SUM(mark_details.mark_value) as total_marks,(SUM(mark_details.mark_value)/(SELECT COUNT(id) FROM marks as m WHERE subject_id=marks.subject_id AND student_id='3')) avg_mark FROM mark_details,marks WHERE mark_details.mark_id=marks.id AND marks.student_id='3' AND marks.subject_id='1'
	}   	
	   return view('backend.marks.rank_list',compact('class','students'));
   }
	

}
