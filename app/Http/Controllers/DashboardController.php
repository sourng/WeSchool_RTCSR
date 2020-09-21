<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Auth;
use DB;

class DashboardController extends Controller
{

    public function index()
    {
		$method = Auth::User()->user_type.'_dashboard';
        return $this->$method();
    }
	
	
	private function Admin_dashboard(){
		$month = date('m');
		$year = date('Y');

		$data = array();
		$data['currency'] = get_option('currency_symbol');
		$data['total_student'] = \App\Student::join("student_sessions","students.id","student_sessions.student_id")
		                                     ->selectRaw("COUNT(students.id) as total_student")
											 ->where("student_sessions.session_id",get_option("academic_year"))->first()->total_student;
		
		$data['student_payments'] = \App\StudentPayment::selectRaw("IFNULL(SUM(amount),0) as total")
		                                                ->whereMonth("date",$month) 
													    ->whereYear("date",$year) 
														->first()->total;
														
		$data['monthly_income'] = \App\Transaction::selectRaw("IFNULL(SUM(amount),0) as total")
		                                                ->where("dr_cr","cr")
														->whereMonth("trans_date",$month) 
													    ->whereYear("trans_date",$year) 														
														->first()->total;
		
		$data['monthly_expense'] = \App\Transaction::selectRaw("IFNULL(SUM(amount),0) as total")
		                                                ->where("dr_cr","dr") 
														->whereMonth("trans_date",$month) 
													    ->whereYear("trans_date",$year) 
														->first()->total;	

        $data['yearly_income'] = $this->yearly_income();
		$data['yearly_expense'] = $this->yearly_expense();		
		$data['awards'] = \App\Award::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
		return view('backend.dashboard.'.Auth::User()->user_type,$data);	
	}
	
	private function Student_dashboard(){
		$month = date('m');
		$year = date('Y');
		$data = array();
		
		$data['total_paid'] = \App\Invoice::join("student_payments","student_payments.invoice_id","invoices.id")
										    ->where("student_id",get_student_id())
		                                    ->where("session_id",get_option("academic_year"))
											->selectRaw("IFNULL(SUM(student_payments.amount),0) as total_paid")
											->first()->total_paid;
		
		$data['paid_invoice'] = \App\Invoice::where("student_id",get_student_id())
		                                    ->where("status","paid")
		                                    ->where("session_id",get_option("academic_year"))
											->selectRaw("COUNT(id) as total_invoice")
											->first()->total_invoice;
											
		$data['unpaid_invoice'] = \App\Invoice::where("student_id",get_student_id())
		                                    ->where("status","unpaid")
		                                    ->where("session_id",get_option("academic_year"))
											->selectRaw("COUNT(id) as total_invoice")
											->first()->total_invoice;
		
		return view('backend.dashboard.'.Auth::User()->user_type,$data);	
	}
	
	private function Teacher_dashboard(){
		$month = date('m');
		$year = date('Y');
		$data = array();
		
		$data['total_student'] = \App\Student::join("student_sessions","students.id","student_sessions.student_id")
		                                     ->selectRaw("COUNT(students.id) as total_student")
											 ->where("student_sessions.session_id",get_option("academic_year"))->first()->total_student;
		
		$data['my_subject_count'] = \App\Subject::join("assign_subjects","subjects.id","assign_subjects.subject_id")
		                                    ->where("assign_subjects.teacher_id",get_teacher_id())
											->selectRaw(" COUNT(subjects.id) as my_subject_count")
											->first()->my_subject_count;
							
		$data['awards'] = \App\Award::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
		return view('backend.dashboard.'.Auth::User()->user_type,$data);	
	}
	
	private function Parent_dashboard(){
		$month = date('m');
		$year = date('Y');
		$data = array();
		
		return view('backend.dashboard.'.Auth::User()->user_type,$data);	
	}
	
	private function Librarian_dashboard(){
		$month = date('m');
		$year = date('Y');
		$data = array();
		
		$data['total_books'] = \App\Book::selectRaw("SUM(quantity) as quantity")
		                                 ->first()->quantity;
										 
		$data['total_member'] = \App\LibraryMember::selectRaw("COUNT(id) as total")
												  ->first()->total;
										 
		$data['issuing_book'] = \App\BookIssue::selectRaw("COUNT(id) as total")
		                                      ->where("status",1)
		                                      ->first()->total;
		$data['awards'] = \App\Award::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
		return view('backend.dashboard.'.Auth::User()->user_type,$data);	
	}
	
	private function Accountant_dashboard(){
		$month = date('m');
		$year = date('Y');
		$data = array();
		
		$data['currency'] = get_option('currency_symbol');
		$data['total_student'] = \App\Student::join("student_sessions","students.id","student_sessions.student_id")
		                                     ->selectRaw("COUNT(students.id) as total_student")
											 ->where("student_sessions.session_id",get_option("academic_year"))->first()->total_student;
		
		$data['student_payments'] = \App\StudentPayment::selectRaw("IFNULL(SUM(amount),0) as total")
		                                                ->whereMonth("date",$month) 
													    ->whereYear("date",$year) 
														->first()->total;
														
		$data['monthly_income'] = \App\Transaction::selectRaw("IFNULL(SUM(amount),0) as total")
		                                                ->where("dr_cr","cr")
														->whereMonth("trans_date",$month) 
													    ->whereYear("trans_date",$year) 														
														->first()->total;
		
		$data['monthly_expense'] = \App\Transaction::selectRaw("IFNULL(SUM(amount),0) as total")
		                                                ->where("dr_cr","dr") 
														->whereMonth("trans_date",$month) 
													    ->whereYear("trans_date",$year) 
														->first()->total;	

        $data['yearly_income'] = $this->yearly_income();
		$data['yearly_expense'] = $this->yearly_expense();
		$data['awards'] = \App\Award::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
		return view('backend.dashboard.'.Auth::User()->user_type,$data);	
	}
	
	private function Employee_dashboard(){
		$month = date('m');
		$year = date('Y');
		$data = array();
		$data['awards'] = \App\Award::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
		return view('backend.dashboard.'.Auth::User()->user_type,$data);	
	}
	
	
	private function yearly_income(){
		$date = date("Y-m-d");
		$income  = "[";
		$income_query = DB::select("SELECT m.month, IFNULL(SUM(t.amount),0) as income_amount 
		FROM ( SELECT 1 AS MONTH UNION SELECT 2 AS MONTH UNION SELECT 3 AS MONTH 
		UNION SELECT 4 AS MONTH UNION SELECT 5 AS MONTH UNION SELECT 6 AS MONTH 
		UNION SELECT 7 AS MONTH UNION SELECT 8 AS MONTH UNION SELECT 9 AS MONTH 
		UNION SELECT 10 AS MONTH UNION SELECT 11 AS MONTH UNION SELECT 12 AS MONTH ) AS m 
		LEFT JOIN transactions t ON m.month = MONTH(t.trans_date) AND YEAR(t.trans_date)=YEAR('$date') 
		AND t.trans_type='income' GROUP BY m.month ORDER BY m.month ASC");
		foreach($income_query as $row){
			$income .=$row->income_amount.",";
		}
		return $income."]";
	}
	
	private function yearly_expense(){
		$date = date("Y-m-d");
		$expense  = "[";
		$expense_query = DB::select("SELECT m.month, IFNULL(SUM(t.amount),0) as expense_amount 
		FROM ( SELECT 1 AS MONTH UNION SELECT 2 AS MONTH UNION SELECT 3 AS MONTH 
		UNION SELECT 4 AS MONTH UNION SELECT 5 AS MONTH UNION SELECT 6 AS MONTH 
		UNION SELECT 7 AS MONTH UNION SELECT 8 AS MONTH UNION SELECT 9 AS MONTH 
		UNION SELECT 10 AS MONTH UNION SELECT 11 AS MONTH UNION SELECT 12 AS MONTH ) AS m 
		LEFT JOIN transactions t ON m.month = MONTH(t.trans_date) AND YEAR(t.trans_date)=YEAR('$date') 
		AND t.trans_type='expense' GROUP BY m.month ORDER BY m.month ASC");
		foreach($expense_query as $row){
			$expense .=$row->expense_amount.",";
		}
		
		return $expense."]";
	}
	
   
}
