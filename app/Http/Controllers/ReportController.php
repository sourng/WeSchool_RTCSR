<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    
    public function student_attendance_report(Request $request, $view="")
    {
		$class_id =0;
		$section_id ="";
		$month = "";
		if($view == ""){
			return view('backend.reports.student_attendance_report',compact('class_id','section_id','month'));
        }else{
			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$class = get_class_name($class_id);
			$section = get_section_name($section_id);
			$month = (explode("/",$request->month));
			$num_of_days =  cal_days_in_month(CAL_GREGORIAN, $month[0], $month[1]);

			$query = DB::table('student_attendances')
					->whereMonth('date', $month[0])
					->whereYear('date', $month[1])
					->orderBy('date', 'asc')
					->get();
						
	        $query2 = DB::table("students")
						->join("student_sessions","students.id","=","student_sessions.student_id")
			            ->where("student_sessions.class_id",$class_id)
			            ->where("student_sessions.section_id",$section_id)
						->orderBy('students.id', 'asc')
						->get();
						
			$report_data = array();
			$students = array();
			
			for($i = 1; $i<=$num_of_days; $i++){		
				$date = new \DateTime($month[1]."-".$month[0]."-".$i);
			    $date = $date->format('Y-m-d');
				$attendance_value = array("0"=>"","1"=>"P","2"=>"A","3"=>"L","4"=>"H");
				foreach($query as $data){
					if($date == $data->date){			
						$report_data[$data->student_id][$date] = $attendance_value[$data->attendance];
					}else{
						if(! isset($report_data[$data->student_id][$date])){
							$report_data[$data->student_id][$date] = $attendance_value[0];
						}
					}	
				}				
			}

			foreach($query2 as $student){
				$students[$student->student_id] = $student;
			}			
	        
			
			$month = $request->month;
		    return view('backend.reports.student_attendance_report',compact('class_id','section_id','class','section','report_data','num_of_days','students','month'));
		}
	}
	
	 public function staff_attendance_report(Request $request, $view="")
    {
		$user_type ="";
		$month = "";
		if($view == ""){
			return view('backend.reports.staff_attendance_report',compact('user_type','month'));
        }else{
			$user_type = $request->user_type;
			$month = (explode("/",$request->month));
			$num_of_days =  cal_days_in_month(CAL_GREGORIAN, $month[0], $month[1]);

			$query = DB::table('staff_attendances')
					->join("users","users.id","=","staff_attendances.user_id")
					->select('staff_attendances.*')
					->where("user_type",$user_type)
					->whereMonth('date', $month[0])
					->whereYear('date', $month[1])
					->orderBy('date', 'asc')
					->get();
						
	        $query2 = DB::table("users")						
			            ->where("users.user_type",$user_type)
						->orderBy('users.id', 'asc')
						->get();
						
			$report_data = array();
			$users = array();
			
			for($i = 1; $i<=$num_of_days; $i++){		
				$date = new \DateTime($month[1]."-".$month[0]."-".$i);
			    $date = $date->format('Y-m-d');
				$attendance_value = array("0"=>"","1"=>"P","2"=>"A","3"=>"L","4"=>"H","5"=>"Le");
				foreach($query as $data){
					if($date == $data->date){			
						$report_data[$data->user_id][$date] = $attendance_value[$data->attendance];
					}else{
						if(! isset($report_data[$data->user_id][$date])){
							$report_data[$data->user_id][$date] = $attendance_value[0];
						}
					}	
				}				
			}

			foreach($query2 as $user){
				$users[$user->id] = $user;
			}			
	        
			
			$month = $request->month;
		    return view('backend.reports.staff_attendance_report',compact('user_type','report_data','users','num_of_days','month'));
		}
	}
	
	public function student_id_card(Request $request, $view=""){
		$class_id = 0;
		$section_id = "";
		
		if($view == ""){
			return view('backend.reports.student_id_card',compact('class_id','section_id'));
        }else{
			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$student_id = $request->student_id;
			$student = DB::table("students")
			         ->join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->join('sections','sections.id','=','student_sessions.section_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$student_id)->first();
			return view('backend.reports.student_id_card',compact('class_id','section_id','student'));
			
		}
	}
	
	public function exam_report(Request $request, $view=""){
		$class_id = 0;
		$section_id = "";
		$exam_id = "";
		
		if($view == ""){
			return view('backend.reports.exam_report',compact('class_id','section_id','exam_id'));
        }else{
			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$exam_id = $request->exam_id;
			$student_id = $request->student_id;
			
			
			$student =  DB::table("students")->join('users','users.id','=','students.user_id')
						->join('student_sessions','students.id','=','student_sessions.student_id')
						->join('classes','classes.id','=','student_sessions.class_id')
						->leftjoin('student_groups','student_groups.id','=','students.group')
						->join('sections','sections.id','=','student_sessions.section_id')
						->where('student_sessions.session_id',get_option('academic_year'))
						->where('students.id',$student_id)->first();
					 
			$exam = DB::table("exams")->where("id",$exam_id)->first();    
			

			$subjects = DB::table("subjects")->where("class_id",$class_id)->get(); 
			
			$existing_marks = DB::select("SELECT marks.subject_id, marks.exam_id,mark_details.* from mark_details,marks WHERE mark_details.mark_id=marks.id 
			AND marks.class_id=:class AND marks.student_id=:student AND marks.exam_id=:exam_id", ["class"=>$class_id, "student"=>$student_id, "exam_id" => $exam_id]);
			 
			 
			$mark_head = DB::select("SELECT distinct mark_details.mark_type from mark_distributions 
			JOIN mark_details JOIN marks ON mark_details.mark_type = mark_distributions.mark_distribution_type 
			AND mark_details.mark_id=marks.id WHERE 
			marks.class_id=:class AND marks.student_id=:student AND marks.exam_id=:exam_id", ["class"=>$class_id, "student"=>$student_id, "exam_id" => $exam_id]);
		
			$mark_details = [];
				
			foreach($existing_marks as $key=>$val){
				if($val->mark_id != ""){
				   $mark_details[$val->subject_id][$val->exam_id][$val->mark_type] = $val;
				}
			}
			
			return view('backend.reports.exam_report',compact('class_id','section_id','exam_id','student','exam', 'mark_head', 'mark_details', 'subjects'));
	
		}
	}
	
	public function progress_card(Request $request, $view=""){
		$class_id = 0;
		$section_id = "";
		$exam_id = "";
		
		if($view == ""){
			return view('backend.reports.progress_card',compact('class_id','section_id'));
        }else{
			$class_id = $request->class_id;
			$section_id = $request->section_id;
			$student_id = $request->student_id;
			
			
			$student = DB::table("students")->join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->leftjoin('student_groups','student_groups.id','=','students.group')
                     ->join('sections','sections.id','=','student_sessions.section_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$student_id)->first();
					 
			$exams = DB::select("SELECT marks.exam_id,marks.class_id,marks.section_id,marks.subject_id, exams.name 
			FROM marks,exams WHERE marks.exam_id=exams.id AND marks.student_id=:student_id
			AND marks.class_id=:class GROUP BY marks.exam_id", ["student_id" => $student_id, "class" => $class_id]);    
			
			$subjects = DB::table("subjects")->where("class_id",$class_id)->get(); 
			
			$existing_marks = DB::select("SELECT marks.subject_id, marks.exam_id,mark_details.* from mark_details,marks WHERE mark_details.mark_id=marks.id 
			AND marks.class_id=:class AND marks.student_id=:student", ["class"=>$class_id, "student"=>$student_id]);
			 
			 
			$mark_head = DB::select("SELECT distinct mark_details.mark_type from mark_distributions 
			JOIN mark_details JOIN marks ON mark_details.mark_type = mark_distributions.mark_distribution_type 
			AND mark_details.mark_id=marks.id WHERE 
			marks.class_id=:class AND marks.student_id=:student", ["class"=>$class_id, "student"=>$student_id]);
		
			$mark_details = [];
				
			foreach($existing_marks as $key=>$val){
				if($val->mark_id != ""){
				   $mark_details[$val->subject_id][$val->exam_id][$val->mark_type] = $val;
				}
			}
			
			return view('backend.reports.progress_card',compact('class_id','section_id','student','exams', 'mark_head', 'mark_details', 'subjects'));
	
		}
	}
	
	public function class_routine(Request $request, $view=""){
		$class_id = 0;
		$section_id = "";
		
		if($view == ""){
			return view('backend.reports.class_routine',compact('class_id','section_id'));
        }else{
			$data = array();
			$data['class_id'] = $request->class_id;
			$data['section_id'] = $request->section_id;
			$data['class'] = \App\ClassModel::find($request->class_id);
			$data['section'] = \App\Section::find($request->section_id);
			$data['routine'] = \App\ClassRoutine::getRoutineView($request->class_id, $request->section_id);
		    
			return view('backend.reports.class_routine',$data);
			
		}
	}
	
	public function exam_routine(Request $request, $view=""){
		$class_id = 0;
		$exam_id = "";
		
		if($view == ""){
			return view('backend.reports.exam_routine',compact('class_id','exam_id'));
        }else{
			$data = array();
			$data['class_id'] = $request->class_id;
			$data['exam_id'] = $request->exam_id;
			$exam = $request->exam_id;;
			$data['subjects'] = \App\Subject::select('*','exam_schedules.id as schedules_id','subjects.id as subject_id')
								->leftJoin('exam_schedules',function($join) use ($exam) {
									$join->on('subjects.id', '=', 'exam_schedules.subject_id');
									$join->where('exam_schedules.exam_id',$exam);
								})
								->where('subjects.class_id',$request->class_id)
								->get();
		    
			return view('backend.reports.exam_routine',$data);
			
		}
	}
	
	public function income_report(Request $request, $view=""){
        $date1 = "";
        $date2 = "";
		if($view == ""){
			return view('backend.reports.income_report',compact('date1','date2'));
        }else{
			$date1 = $request->date1;
			$date2 = $request->date2;
			$report_data = \App\Transaction::select('transactions.*','chart_of_accounts.name as c_type','bank_cash_accounts.account_name',
							'payee_payers.name as payee_payer','payment_methods.name as payment_method','transactions.id as id')
							->join("bank_cash_accounts","bank_cash_accounts.id","=","transactions.account_id")
							->join("chart_of_accounts","chart_of_accounts.id","=","transactions.id")
							->leftjoin("payment_methods","payment_methods.id","=","transactions.payment_method_id")
							->leftjoin("payee_payers","payee_payers.id","=","transactions.payee_payer_id")
							->where("transactions.trans_type","income")
							->whereBetween('trans_date', [$date1, $date2])
							->orderBy("transactions.id","DESC")->get();
			
			$summary = DB::select("SELECT SUM(amount) as total 
					   FROM transactions WHERE trans_type='income'
					   AND trans_date BETWEEN :date1 AND :date2",["date1"=>$date1,"date2"=>$date2])[0];			
			
			
			return view('backend.reports.income_report',compact('date1','date2','report_data','summary'));
			
		}
		
	}
	
	public function expense_report(Request $request, $view=""){
        $date1 = "";
        $date2 = "";
		if($view == ""){
			return view('backend.reports.expense_report',compact('date1','date2'));
        }else{
			$date1 = $request->date1;
			$date2 = $request->date2;
			$report_data = \App\Transaction::select('transactions.*','chart_of_accounts.name as c_type','bank_cash_accounts.account_name',
							'payee_payers.name as payee_payer','payment_methods.name as payment_method','transactions.id as id')
							->join("bank_cash_accounts","bank_cash_accounts.id","=","transactions.account_id")
							->join("chart_of_accounts","chart_of_accounts.id","=","transactions.id")
							->leftjoin("payment_methods","payment_methods.id","=","transactions.payment_method_id")
							->leftjoin("payee_payers","payee_payers.id","=","transactions.payee_payer_id")
							->where("transactions.trans_type","expense")
							->whereBetween('trans_date', [$date1, $date2])
							->orderBy("transactions.id","DESC")->get();
		    
			$summary = DB::select("SELECT SUM(amount) as total 
					   FROM transactions WHERE trans_type='expense'
					   AND trans_date BETWEEN :date1 AND :date2",["date1"=>$date1,"date2"=>$date2])[0];			
			
			
			return view('backend.reports.expense_report',compact('date1','date2','report_data','summary'));
			
		}	
	}
	
	public function account_balance(){
		$report_data = DB::select("SELECT bank_cash_accounts.*,((SELECT IFNULL(SUM(amount),0) as income 
		FROM transactions WHERE dr_cr='cr' AND account_id=bank_cash_accounts.id) - (SELECT IFNULL(SUM(amount),0) 
		as expense FROM transactions WHERE dr_cr='dr' AND account_id=bank_cash_accounts.id)) current_balance 
		FROM bank_cash_accounts");			
		return view('backend.reports.financial_account_balace',compact('report_data'));	
	}

    
}
