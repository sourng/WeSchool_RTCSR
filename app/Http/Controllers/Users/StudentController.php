<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use Stripe\Charge;
use Auth;
use DB;

class StudentController extends Controller
{

    public function my_profile()
    {
		$student = \App\Student::join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->join('sections','sections.id','=','student_sessions.section_id')
                     ->join('parents','parents.id','=','students.parent_id')
					 ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',get_student_id())->first();
        return view('backend.private.student.profile',compact('student'));	
    }
	
	public function my_subjects()
    {
		$student = \App\StudentSession::where("student_id",get_student_id())
								      ->where("session_id",get_option('academic_year'))
									  ->first();
		
		$subjects = \App\Subject::select('*','subjects.id AS id')
					->join('classes','classes.id','=','subjects.class_id')
					->where('subjects.class_id', $student->class_id)
					->orderBy('subjects.id', 'DESC')
					->get();			
        return view('backend.private.student.subject',compact('subjects'));	
    }
	
	public function class_routine(){
		
		$student = \App\StudentSession::where("student_id",get_student_id())
								      ->where("session_id",get_option('academic_year'))
									  ->first();
									  
		$data = array();
        $data['class'] = \App\ClassModel::find($student->class_id);
        $data['section'] = \App\Section::find($student->section_id);
        $data['routine'] = \App\ClassRoutine::getRoutineView($student->class_id, $student->section_id);
		
		return view('backend.private.student.class_routine',$data);
	}	
	
	public function exam_routine(Request $request, $view=""){
		$class_id = 0;
		$exam_id = "";
		
		if($view == ""){
			return view('backend.private.student.exam_routine',compact('class_id','exam_id'));
        }else{
			$student = \App\StudentSession::where("student_id",get_student_id())
								      ->where("session_id",get_option('academic_year'))
									  ->first();
									  
			$data = array();
			$data['class_id'] = $student->class_id;
			$data['exam_id'] = $request->exam_id;
			$exam = $request->exam_id;;
			$data['subjects'] = \App\Subject::select('*','exam_schedules.id as schedules_id','subjects.id as subject_id')
								->leftJoin('exam_schedules',function($join) use ($exam) {
									$join->on('subjects.id', '=', 'exam_schedules.subject_id');
									$join->where('exam_schedules.exam_id',$exam);
								})
								->where('subjects.class_id',$student->class_id)
								->get();
		    
			return view('backend.private.student.exam_routine',$data);
			
		}
	}
		
	public function progress_card(){
		$class_id = 0;
		$section_id = "";
		$exam_id = "";
			
		$student = \App\StudentSession::where("student_id",get_student_id())
								      ->where("session_id",get_option('academic_year'))
								      ->first();
								  
		$class_id = $student->class_id;
		$section_id = $student->section_id;
		$student_id = $student->student_id;
		
		
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
		
		return view('backend.private.student.progress_card',compact('class_id','section_id','student','exams', 'mark_head', 'mark_details', 'subjects'));

	}	
	
	public function my_invoice( $status="unpaid" )
    {
		 $invoices = \App\Invoice::join('students','invoices.student_id','=','students.id')
							->join('student_sessions','students.id','=','student_sessions.student_id')
							->join('classes','classes.id','=','student_sessions.class_id')
							->join('sections','sections.id','=','student_sessions.section_id')
							->select('invoices.*','students.first_name','students.last_name','student_sessions.roll','classes.class_name','sections.section_name','invoices.id as id')						
							->where('student_sessions.session_id',get_option('academic_year'))
							->where('invoices.session_id',get_option('academic_year'))
							->where('invoices.student_id',get_student_id())
							->where('invoices.status',$status)
							->orderBy('invoices.id', 'DESC')
							->get();
							
        return view('backend.private.student.invoice.list',compact('invoices'));
    }
	
	public function view_invoice(Request $request,$id)
    { 
		$invoice = \App\Invoice::join('students','invoices.student_id','=','students.id')
							->join('student_sessions','students.id','=','student_sessions.student_id')
                            ->join('classes','classes.id','=','student_sessions.class_id')
                            ->join('sections','sections.id','=','student_sessions.section_id')
							->select('invoices.*','students.first_name','students.last_name','student_sessions.roll','classes.class_name','sections.section_name','invoices.id as id')						
							->where('student_sessions.session_id',get_option('academic_year'))
							->where('invoices.session_id',get_option('academic_year'))
							->where('invoices.student_id',get_student_id())
							->where('invoices.id',$id)->first();
		$invoiceItems = \App\InvoiceItem::join("fee_types","invoice_items.fee_id","=","fee_types.id")
		                ->where("invoice_id",$id)->get();
						
		$transactions = \App\StudentPayment::where("invoice_id",$id)->get();
		
		if(! $request->ajax()){
		    return view('backend.private.student.invoice.view',compact('invoice','id','invoiceItems','transactions'));
		}else{
			return view('backend.private.student.invoice.modal.view',compact('invoice','id','invoiceItems','transactions'));
		} 
        
    }
	
	public function invoice_payment($method,$invoice_id){
		if($method == 'paypal'){
			$invoice = \App\Invoice::where("id",$invoice_id)
			                       ->where("student_id",get_student_id())->first();					   
			return view('backend.private.student.payment_gateway.paypal',compact('invoice'));
		}else if($method == 'stripe'){
			$invoice = \App\Invoice::where("id",$invoice_id)
			                       ->where("student_id",get_student_id())->first();					   
			return view('backend.private.student.payment_gateway.stripe',compact('invoice'));
		}
	}
	
	public function paypal($action){
		if($action == "return"){
			return redirect('student/my_invoice/paid')->with('success', _lang('Thank you, Your payment has done sucessfully'));
		}else if($action == "cancel"){
			return redirect('student/my_invoice/unpaid')->with('error', _lang('Payment Canceled !'));
		}
	}
	
	public function stripe_payment($invoice_id){
		Stripe::setApiKey(get_option('stripe_secret_key'));
 
        $token = request('stripeToken');
		
		$invoice = \App\Invoice::where("id",$invoice_id)
			                   ->where("student_id",get_student_id())->first();	
 
        $charge = Charge::create([
            'amount' => $invoice->total - $invoice->paid,
            'currency' => get_option('stripe_currency'),
            'description' => $invoice->title,
            'source' => $token,
        ]);
		
		$studentpayment= new \App\StudentPayment();
		$studentpayment->invoice_id = $invoice->id;
		$studentpayment->date = date("Y-m-d");
		$studentpayment->amount = $invoice->total - $invoice->paid;
		$studentpayment->note = "Pay Using Stripe";
		$studentpayment->save();

		$in= \App\Invoice::find($invoice->id);
		$in->status = "Paid";
		$in->paid = $invoice->total;
		$in->save();
 
        return redirect('student/my_invoice/paid')->with('success', _lang('Thank you, Your payment has done sucessfully'));
	}
	
	public function payment_history()
    {
		$studentpayments = \App\StudentPayment::join('invoices','invoices.id','=','student_payments.invoice_id')
								->select('invoices.*','student_payments.*','student_payments.id as id')						
								->where('invoices.session_id',get_option('academic_year'))
								->where('invoices.student_id',get_student_id())
								->orderBy('student_payments.id', 'DESC')
								->get(); 								
        return view('backend.private.student.payment_history',compact('studentpayments'));
    }
	
	public function library_history()
    {
		$member = \App\LibraryMember::join('users','users.id','=','library_members.user_id')->where('library_members.user_id',\Auth::user()->id)->first();
		$issues = array();
		if($member != NULL){
			$issues = \App\BookIssue::select('*','book_issues.id AS id')
								->join('books','books.id','=','book_issues.book_id')
								->join('book_categories','book_categories.id','=','books.category_id')
								->where('book_issues.library_id',$member->library_id)
								->orderBy('book_issues.id', 'DESC')
								->get();
		}					
		return view('backend.private.student.library_history',compact('issues','member'));
    }

	public function my_assignment()
	{
		$student = \App\StudentSession::where("student_id",get_student_id())
								  ->where("session_id",get_option('academic_year'))
								  ->first();
        $assignments = \App\Assignment::select('*','assignments.id AS id')
                            ->join('subjects','subjects.id','=','assignments.class_id')
							->where('assignments.class_id',$student->class_id)
							->where('assignments.section_id',$student->section_id)
                            ->where('assignments.session_id', get_option('academic_year'))
							->orderBy('assignments.id', 'DESC')
                            ->get();
        return view('backend.private.student.assignments.assignment-list',compact('assignments'));
    }
	
	public function view_assignment($id)
    {
		$student = \App\StudentSession::where("student_id",get_student_id())
								  ->where("session_id",get_option('academic_year'))
								  ->first();
								  
        $assignment = \App\Assignment::select('*','assignments.id AS id')
                            ->join('classes','classes.id','=','assignments.class_id')
                            ->join('sections','sections.id','=','assignments.class_id')
                            ->join('subjects','subjects.id','=','assignments.class_id')
                            ->where('assignments.id',$id)
							->where('assignments.session_id', get_option('academic_year'))
                            ->where('assignments.class_id',$student->class_id)
							->where('assignments.section_id',$student->section_id)
                            ->first();

        return view('backend.private.student.assignments.assignment-show',compact('assignment'));
    }
	
	public function my_syllabus()
    {
		$student = \App\StudentSession::where("student_id",get_student_id())
								  ->where("session_id",get_option('academic_year'))
								  ->first();
								  
        $syllabus = \App\Syllabus::select('*','syllabus.id AS id')
                            ->join('classes','classes.id','=','syllabus.class_id')
                            ->where('syllabus.class_id',$student->class_id)
							->where('syllabus.session_id', get_option('academic_year'))
							->orderBy('syllabus.id', 'DESC')
                            ->get();
        return view('backend.private.student.syllabus.syllabus-list',compact('syllabus'));
    }
	
	public function view_syllabus($id)
    {
		$student = \App\StudentSession::where("student_id",get_student_id())
								  ->where("session_id",get_option('academic_year'))
								  ->first();
								  
        $syllabus = \App\Syllabus::select('*','syllabus.id AS id')
                            ->join('classes','classes.id','=','syllabus.class_id')
                            ->where('syllabus.class_id',$student->class_id)
							->where('syllabus.id',$id)
                            ->where('syllabus.session_id', get_option('academic_year'))
							->first();
        return view('backend.private.student.syllabus.syllabus-view',compact('syllabus'));
    }
	
   
}
