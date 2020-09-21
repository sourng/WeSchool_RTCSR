<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Rules\UniqueRoll;
use App\Student;
use App\StudentSession;
use App\User;
use App\ClassModel;
use App\Section;
use App\Subject;
use DB;
use Validator;
use Hash;
use Image;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$students = array();
    	$class = "";		
    	return view('backend.students.student-list',compact('students','class'));
    }

    public function class($class='')
    {
    	$class = $class;
    	$students = Student::join('users','users.id','=','students.user_id')
    	->join('student_sessions','students.id','=','student_sessions.student_id')
    	->join('classes','classes.id','=','student_sessions.class_id')
    	->join('sections','sections.id','=','student_sessions.section_id')
    	->select('users.*','student_sessions.roll','classes.class_name','sections.section_name','students.id as id')						
    	->where('student_sessions.session_id',get_option('academic_year'))
    	->where('student_sessions.class_id',$class)
    	->where('users.user_type','Student')
    	->orderBy('student_sessions.roll', 'ASC')
    	->get();							
    	return view('backend.students.student-list',compact('students','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$sections = Section::orderBy('id', 'DESC')->get();
    	return view('backend.students.student-add',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function excel_import(Request $request)
    {
    	if( ! $request->ajax()){
    		return view('backend.students.excel_import');
    	}else{
    		return view('backend.students.modal.excel_import');
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
    	$this->validate($request, [
    		'first_name' => 'required|string|max:191',
    		'last_name' => 'required|string|max:191',
    		'birthday' => 'required',
    		'gender' => 'required|string|max:10',
    		'blood_group' => 'nullable|string|max:4',
    		'religion' => 'nullable|string|max:20',
    		'phone' => 'required|max:20',
    		'state' => 'nullable|string|max:191',
    		'country' => 'required|string|max:100',
    		'class' => 'required',
    		'section' => 'required',
    		'group' => 'nullable|string|max:191',
    		'register_no' => 'required||unique:students',
    		'roll' =>['required', new UniqueRoll($request->section,$request->roll)],
    		'activities' => 'nullable|string|max:191',
    		'remarks' => 'nullable',
    		'email' => 'required|string|email|max:191|unique:users',
    		'password' => 'required|string|min:6|confirmed',
    		'image' => 'nullable|image|max:5120',
    	]);

    	$ImageName='profile.png';
    	if ($request->hasFile('image')){
    		$image = $request->file('image');
    		$ImageName = time().'.'.$image->getClientOriginalExtension();
    		Image::make($image)->resize(200, 160)->save(base_path('public/uploads/images/students/') . $ImageName);
    	}

		//Create User
    	$user = new User();
    	$user->name = $request->first_name." ".$request->last_name;
    	$user->email = $request->email;
    	$user->password = Hash::make($request->password);
    	$user->user_type = 'Student';
    	$user->phone = $request->phone;
    	$user->image = 'students/'.$ImageName;
    	$user->save();

		//Create Student Information
    	$student = new Student();
    	$student->user_id = $user->id;
    	$student->parent_id = $request->guardian;
    	$student->first_name = $request->first_name;
    	$student->last_name = $request->last_name;
    	$student->birthday = $request->birthday;
    	$student->gender = $request->gender;
    	$student->blood_group = $request->blood_group;
    	$student->religion = $request->religion;
    	$student->phone = $request->phone;
    	$student->address = $request->address;
    	$student->state = $request->state;
    	$student->country = $request->country;
    	$student->register_no = $request->register_no;
    	$student->group = $request->group;
    	$student->activities = $request->activities;
    	$student->remarks = $request->remarks;
    	$student->save();

		//Create Student Session Information
    	$studentSession = new StudentSession();
    	$studentSession->session_id = get_option('academic_year');
    	$studentSession->student_id = $student->id;
    	$studentSession->class_id = $request->class;
    	$studentSession->section_id = $request->section;
    	$studentSession->roll = $request->roll;
    	$studentSession->optional_subject = $request->optional_subject;
    	$studentSession->save();

    	return redirect('students/create')->with('success', _lang('Information has been added'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function excel_store(Request $request)
    {
		@ini_set('max_execution_time', 0);
    	@set_time_limit(0);
		
    	$request->validate([
    		'excel_file' => 'required|mimes:xlsx,xls'
    	]);
		
    	$path = $request->file('excel_file')->getRealPath();
    	$students = (new FastExcel)->import($path, function ($line) {
    		if (($line['email'] != '') && (! User::where('email', $line['email'])->exists())) {

    				$session_id = get_option('academic_year');

    				$class = ClassModel::where('class_name',$line['class'])->first();
    				
					if($class){
    					$class_id = $class->id;
    				}else{
    					$class_id = '';
    				}
					
    				$group = \App\StudentGroup::where('group_name',$line['group'])->first();
    				
					if($group != null){
    					$group_id = $group->id;
    				}else{
    					$group_id = '';
    				}
					
    				$section = Section::where([
    					'section_name' => $line['section'],
    					'class_id' => $class_id
    				])->first();
					
 					if($section != null){
    					$section_id = $section->id;
    				}else{
    					$section_id = '';
    				}
					
    				$where = array();
    				$where['session_id'] = $session_id;
    				$where['class_id'] = $class_id;
    				$where['section_id'] = $section_id;
    				$where['roll'] = $line['roll'];
    				if (($class_id !='') && ($section_id != '') && ($line['roll'] != '') && (!StudentSession::where($where)->exists())) {
						
						/******* parent *******/
						$parent_id = NULL;
						if($line['parent_email'] != ''){
							if(!User::where('email', $line['parent_email'])->exists()){
								
								//parent login data
								$user = new User();
								$user->name = $line['parent_name'];
								$user->email = $line['parent_email'];
								$user->password = Hash::make($line['parent_password']);
								$user->user_type = 'Parent';
								$user->phone = $line['parent_phone'];
								$user->image = 'parents/profile.png';
								$user->save();
								
								//parent data
								$parent = new \App\ParentModel();
								$parent->user_id = $user->id;
								$parent->parent_name = $line['parent_name'];
								$parent->f_name = $line['father_name'];
								$parent->m_name = $line['mother_name'];
								$parent->f_profession = $line['father_profession'];
								$parent->m_profession = $line['mother_profession'];
								$parent->phone = $line['parent_phone'];
								$parent->address = $line['parent_address'];
								$parent->save();
								$parent_id = $parent->id;
							}else{
								$user_id = User::where('email', $line['parent_email'])->first()->id;
								$parent_id = \App\ParentModel::where('user_id', $user_id)->first()->id;
							}
						}
						/******* End parent *******/
						
						/******* student *******/
						//student login data
						$user = new User();
						$user->name = $line['first_name']." ".$line['last_name'];
						$user->email = $line['email'];
						$user->password = Hash::make($line['password']);
						$user->user_type = 'Student';
						$user->phone = $line['phone'];
						$user->image = 'students/profile.png';
						$user->save();
						
						//student data
						$student = new Student();
						$student->user_id = $user->id;
						$student->parent_id = $parent_id;
						$student->first_name = $line['first_name'];
						$student->last_name = $line['last_name'];
						$student->birthday = $line['birthday'];
						$student->gender = $line['gender'];
						$student->blood_group = $line['blood_group'];
						$student->religion = $line['religion'];
						$student->phone = $line['phone'];
						$student->address = $line['address'];
						$student->state = $line['state'];
						$student->country = $line['country'];
						$student->register_no = $line['register_no'];
						$student->group = $group_id;
						$student->activities = $line['activities'];
						$student->remarks = $line['remarks'];
						$student->save();
						
						//student's session data
						$studentSession = new StudentSession();
						$studentSession->session_id = $session_id;
						$studentSession->student_id = $student->id;
						$studentSession->class_id = $class_id;
						$studentSession->section_id = $section_id;
						$studentSession->roll = $line['roll'];
						$studentSession->optional_subject = $line['optional_subject'];
						$studentSession->save();
						/******* student *******/
			        
					}//End 3rd bracket
				
			} //End First bracket
		});
		return redirect('students')->with('success', _lang('Information has been imported sucessfully'));
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {								
    	$student = Student::select('*','students.id AS id')
                            ->join('users','users.id','=','students.user_id')
                        	->join('student_sessions','students.id','=','student_sessions.student_id')
                        	->join('classes','classes.id','=','student_sessions.class_id')
                        	->join('sections','sections.id','=','student_sessions.section_id')
                        	->where('student_sessions.session_id',get_option('academic_year'))
                        	->where('students.id',$id)->first();
        $parent = \App\ParentModel::select('*')
                                    ->join('users','users.id','=','parents.user_id')
                                    ->where('parents.id',$student->parent_id)->first();
        $invoices = \App\Invoice::select('*')
                                    ->join('student_sessions','student_sessions.student_id','=','invoices.student_id')                    
                                    ->where('invoices.session_id',get_option('academic_year'))
                                    ->where('invoices.student_id',$student->id)
                                    ->orderBy('invoices.id', 'DESC')
                                    ->get();
        $payments_history = \App\StudentPayment::select('*')
                            ->join('invoices','invoices.id','=','student_payments.invoice_id')
                            ->where('invoices.session_id',get_option('academic_year'))
                            ->where('invoices.student_id',$student->id)
                            ->orderBy('student_payments.id', 'DESC')
                            ->get();
    	return view('backend.students.student-view',compact('student','parent','invoices','payments_history'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data=[
    		'classes' => ClassModel::orderBy('id', 'DESC')->get(),
    		'sections' => Section::orderBy('id', 'DESC')->get(),
    		'student' => Student::join('users','users.id','=','students.user_id')
    		->join('student_sessions','students.id','=','student_sessions.student_id')
    		->select('*','students.id as id','student_sessions.id as ss_id')
    		->where('student_sessions.session_id',get_option('academic_year'))
    		->where('students.id',$id)->first(),
    	];
    	return view('backend.students.student-edit',$data);
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
    	$student = Student::find($id);

    	$this->validate($request, [
    		'first_name' => 'required|string|max:191',
    		'last_name' => 'required|string|max:191',
    		'birthday' => 'required',
    		'gender' => 'required|string|max:10',
    		'blood_group' => 'nullable|string|max:4',
    		'religion' => 'nullable|string|max:20',
    		'phone' => 'required|max:20',
    		'state' => 'nullable|string|max:191',
    		'country' => 'required|string|max:100',
    		'class' => 'required',
    		'section' => 'required',
    		'group' => 'nullable|string|max:191',
    		'register_no' => [
    			'required',
    			Rule::unique('students')->ignore($id),
    		],
    		'roll' =>['required', new UniqueRoll($request->section,$request->roll,$student->id)],
    		'activities' => 'nullable|string|max:191',
    		'remarks' => 'nullable',
    		'email' => [
    			'required',
    			Rule::unique('users')->ignore($student->user_id),
    		],
    		'password' => 'nullable|min:6|confirmed',
    		'image' => 'nullable|image|max:5120',
    	]);


    	$student->parent_id = $request->guardian;
    	$student->first_name = $request->first_name;
    	$student->last_name = $request->last_name;
    	$student->birthday = $request->birthday;
    	$student->gender = $request->gender;
    	$student->blood_group = $request->blood_group;
    	$student->religion = $request->religion;
    	$student->phone = $request->phone;
    	$student->address = $request->address;
    	$student->state = $request->state;
    	$student->country = $request->country;
    	$student->register_no = $request->register_no;
    	$student->group = $request->group;
    	$student->activities = $request->activities;
    	$student->remarks = $request->remarks;
    	$student->save();

		//Update Student Session Information
    	$studentSession = StudentSession::find($request->ss_id);
    	$studentSession->session_id = get_option('academic_year');
    	$studentSession->student_id = $student->id;
    	$studentSession->class_id = $request->class;
    	$studentSession->section_id = $request->section;
    	$studentSession->roll = $request->roll;
    	$studentSession->optional_subject = $request->optional_subject;
    	$studentSession->save();


    	$user = User::find($student->user_id);
    	$user->name = $request->first_name." ".$request->last_name;
    	$user->email = $request->email;
    	$user->phone = $request->phone;
    	if($request->password){
    		$user->password = Hash::make($request->password);
    	}

    	if ($request->hasFile('image')){
    		$image = $request->file('image');
    		$ImageName = time().'.'.$image->getClientOriginalExtension();
    		Image::make($image)->resize(200, 160)->save(base_path('public/uploads/images/students/') . $ImageName);
    		$user->image = 'students/'.$ImageName;
    	}

    	$user->save();


    	return redirect($_SERVER['HTTP_REFERER'])->with('success', _lang('Information has been updated'));
    }

    public function get_subjects( $class_id="" ){
    	if($class_id != ""){
    		$subjects = Subject::where('class_id', $class_id)->get();
    		$options = '';
    		$options .= '<option value="">'._lang('Select One').'</option>';
    		foreach($subjects as $subject){
    			$options .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
    		}
    		return $options;
    	}
    }

    public function get_students( $class_id="", $section_id="" ){
    	if($class_id != "" && $section_id != ""){
    		$students = Student::join('student_sessions','students.id','=','student_sessions.student_id')
    		->select('students.*','student_sessions.roll')	
    		->where('student_sessions.session_id', get_option('academic_year'))
    		->where('student_sessions.class_id', $class_id)
    		->where('student_sessions.section_id', $section_id)->get();

    		return json_encode($students);
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
    	$student = Student::find($id);
    	$student->delete();
		
    	$user = User::find($student->user_id);
    	$user->delete();
		
		$session = StudentSession::where("student_id",$id);
		$session->delete();

    	return redirect()->back()->with('success',_lang('Information has been deleted'));
    }

	//ID Card
    public function id_card($id)
    {								
    	$student = Student::join('users','users.id','=','students.user_id')
    	->join('student_sessions','students.id','=','student_sessions.student_id')
    	->join('classes','classes.id','=','student_sessions.class_id')
    	->join('sections','sections.id','=','student_sessions.section_id')
    	->where('student_sessions.session_id',get_option('academic_year'))
    	->where('students.id',$id)->first();
    	return view('backend.students.modal.id_card',compact('student'));
    }

    public function promote(Request $request,$step=1){
    	$class_id = "";
    	if($step == 1){
    		return view('backend.marks.promote_student.step_one',compact('class_id'));
    	}else if($step == 2){
    		$class_id = $request->class_id;
    		return view('backend.marks.promote_student.step_two',compact('class_id'));
    	}else if($step == 3){
    		@ini_set('max_execution_time', 0);
    		@set_time_limit(0);

    		$failed_students = "";
    		$subjects ="";

    		$class_id = $request->class_id;
    		$promoted_class_id = $request->promote_class_id;
    		$promoted_session = $request->promoted_session;

    		$session = get_option('academic_year');

    		foreach($request->subject as $key=>$val){
    			$subjects .= $key.",";
    		}
    		$subjects = substr_replace($subjects, "", -1);


    		$subjects = DB::select("SELECT marks.student_id,marks.subject_id,SUM(mark_details.mark_value) as total_marks,(SUM(mark_details.mark_value)/(SELECT COUNT(id) 
    			FROM marks as m WHERE subject_id=marks.subject_id AND student_id=marks.student_id)) avg_mark, subjects.pass_mark from mark_details,marks,student_sessions,subjects 
    			WHERE mark_details.mark_id=marks.id AND marks.student_id=student_sessions.student_id AND student_sessions.session_id=:session AND marks.subject_id=subjects.id 
    			AND marks.class_id=:class_id AND subjects.id IN($subjects)
    			GROUP by marks.subject_id,marks.student_id", ["session"=>$session,"class_id"=>$class_id]);

    		foreach($subjects as $subject){
    			if($subject->avg_mark < $subject->pass_mark){
    				$failed_students .= $subject->student_id.",";
    			}
    		}
    		$failed_students = substr_replace($failed_students, "", -1);
    		$query ="";
    		if($failed_students != ""){
    			$query =" AND students.id NOT IN($failed_students) ";
    		}

    		$promotion = DB::select("SELECT marks.student_id,student_sessions.roll, IFNULL(SUM(mark_details.mark_value),0) as total_marks 
    			FROM marks,mark_details,exams,students,student_sessions WHERE marks.id=mark_details.mark_id AND marks.exam_id=exams.id AND 
    			marks.student_id=students.id AND students.id=student_sessions.student_id AND marks.class_id=:class_id AND student_sessions.session_id=:session 
    			$query GROUP BY marks.student_id ORDER BY total_marks DESC", ["class_id"=>$class_id,"session"=>$session]);


    		$sections = Section::where("class_id",$promoted_class_id)->orderBy('rank', 'asc')->get();

    		$sections_count = count($sections);
    		$student_count = count($promotion);


    		if( $sections_count>0 && $student_count>0){

				//$split = ceil($student_count/$sections_count);

    			$section = 0;
    			$counter = 1;
    			$roll = 1;

    			$split = $sections[$section]->capacity;

    			foreach($promotion as $p){
					//Create Student Session Information
    				$studentSession = new StudentSession();
    				$studentSession->session_id = $promoted_session;
    				$studentSession->student_id = $p->student_id;
    				$studentSession->class_id = $promoted_class_id;
    				$studentSession->section_id = $sections[$section]->id;
    				$studentSession->roll = $roll;
    				try {
    					$studentSession->save();
    				} catch (\Illuminate\Database\QueryException $e) {
    					return redirect('students/promote')->with('error',_lang('Sorry, You have already promoted this class!'));
    				} catch (\Exception $e) {
    					return redirect('students/promote')->with('error',_lang('Sorry, You have already promoted this class!'));
    				}


    				$counter++;
    				$roll++;

    				if($counter > $split){
    					$counter = 1;
    					$section++;
    				}
    			}
    			return redirect('students/promote')->with('success',_lang('Student Promoted Sucessfully.'));
    		}else{
    			return redirect('students/promote')->with('error',_lang('Sorry, Section not available for promoted class ! Please create Section first.'));
    		}

    	}
    }

}
