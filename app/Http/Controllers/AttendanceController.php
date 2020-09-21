<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentAttendance AS SAttendance;
use App\StaffAttendance;
use App\LeaveApplication;
use App\Student;
use App\User;
use App\ClassModel;
use App\Section;
use Carbon\Carbon;
use Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function student_attendance(Request $request)
    {
        $attendance = [];
		$class_id = $request->class_id;
		$section_id = $request->section_id;
		$date = $request->date;		
		if($class_id == "" || $section_id == "" || $date == ""){
			return view('backend.attendance.student-attendance',compact('attendance','date','class_id','section_id'));
		}else{		    
			$class = ClassModel::find($class_id)->class_name;
			$section = Section::find($section_id)->section_name;

			$attendance = Student::select('*','student_attendances.id AS attendance_id')
									->leftJoin('student_attendances',function($join) use ($date) {
										$join->on('student_attendances.student_id','=','students.id');
										$join->where('student_attendances.date','=',$date);
									})
									->join('student_sessions','student_sessions.student_id','=','students.id')
									->where('student_sessions.session_id',get_option('academic_year'))
									->where('student_sessions.class_id',$class_id)
									->where('student_sessions.section_id',$section_id)
									->orderBy('student_sessions.roll', 'ASC')
									->get();														                        

			return view('backend.attendance.student-attendance',compact('attendance','date','class','section','class_id','section_id'));
		}
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
    public function student_attendance_save(Request $request)
    {	
		
		$validator = Validator::make($request->all(), [
            'attendance' => 'required',
        ]);
        if ($validator->fails()) {
            
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('student/attendance')
                            ->withErrors($validator)
                            ->withInput();
			}				
        }
		
        for ($i=0; $i < count($request->student_id) ; $i++) {
			$temp = array();
			$temp['student_id'] = (int)$request->student_id[$i];
			$temp['class_id'] = (int)$request->class_id[$i];
			$temp['section_id'] = (int)$request->section_id[$i];
			$temp['date'] = $request->date;
			
			$studentAtt = SAttendance::firstOrNew($temp);
			$studentAtt->student_id = $temp['student_id'];
			$studentAtt->class_id = $temp['class_id'];
			$studentAtt->section_id = $temp['section_id'];
			$studentAtt->date = $temp['date'];
			$studentAtt->attendance = isset($request->attendance[$i]) ? $request->attendance[$i][0] : 0;
			$studentAtt->save();				
        }


		if(! $request->ajax()){
		   return redirect('/student/attendance')->with('success',_lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully')]);
		}
        

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function staff_attendance(Request $request)
    {
        $attendance = [];
		$date = $request->date;
		$user_type = $request->user_type;
		if($date == ""){
			return view('backend.attendance.staff-attendance',compact('attendance','date','user_type'));
		}else{	
			$attendance = User::select('*','users.id as user_id','staff_attendances.id as attendance_id')
								    ->leftJoin('staff_attendances',function($join) use ($date) {
										$join->on('users.id','=','staff_attendances.user_id');
										$join->where('staff_attendances.date','=',$date);
									})
									->leftJoin('leave_applications',function($join) use ($date) {
										$join->on('users.id','=','leave_applications.user_id');
										$join->where('leave_applications.date','=',$date);
									})
									->where('user_type',$user_type)
									->orderBy('users.id', 'DESC')
									->get();	
			return view('backend.attendance.staff-attendance',compact('attendance','date','user_type'));
        }
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function staff_attendance_save(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'attendance' => 'required',
        ]);
		
        if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('staff/attendance')
                            ->withErrors($validator)
                            ->withInput();
			}      
        }
        //dd($request->attendance);
        for ($i=0; $i < count($request->user_id) ; $i++) {

			$temp = array();
			$temp['user_id'] = $request->user_id[$i];
			$temp['date'] = $request->date;
			$attendance = isset($request->attendance[$i]) ? $request->attendance[$i][0] : 0;
			$staffAtt = StaffAttendance::firstOrNew($temp);
			$staffAtt->user_id = $temp['user_id'];
			$staffAtt->date = $temp['date'];
			$staffAtt->attendance = $attendance;
			$staffAtt->save();

			if($attendance == 5){
				if(! LeaveApplication::where(['user_id' => $temp['user_id'], 'date' => $temp['date']])->exists()){
					$leave_application = new LeaveApplication();
		            $leave_application->user_id = $temp['user_id'];
		            $leave_application->date = $temp['date'];
		            $leave_application->leave_type_id = $request->leave_type_id[$i];
		            $leave_application->status = 1;
		            $leave_application->save();
				}else{
					$leave_application = LeaveApplication::where(['user_id' => $temp['user_id'], 'date' => $temp['date']])->first();
		            $leave_application->leave_type_id = $request->leave_type_id[$i];
		            $leave_application->save();
				}
			}
			if(LeaveApplication::where(['user_id' => $temp['user_id'], 'date' => $temp['date']])->exists() && $attendance != 5){
				$leave_application = LeaveApplication::where(['user_id' => $temp['user_id'], 'date' => $temp['date']])->first();
				$leave_application->delete();
			}
        }

		if(! $request->ajax()){
		   return redirect('/staff/attendance')->with('success',_lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully')]);
		}
    }
}
