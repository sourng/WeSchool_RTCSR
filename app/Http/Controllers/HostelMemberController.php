<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HostelMember;
use App\HostelCategory;
use App\Student;

class HostelMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class = '')
    {
        if($class != ''){
            $students = Student::join('users','users.id','=','students.user_id')
            ->join('student_sessions','students.id','=','student_sessions.student_id')
            ->join('classes','classes.id','=','student_sessions.class_id')
            ->join('sections','sections.id','=','student_sessions.section_id')
            ->leftJoin('hostel_members',function($join){
                $join->on('hostel_members.student_id','=','students.id');
            })
            ->select('users.*','student_sessions.roll','classes.class_name','sections.section_name','students.id as id','hostel_members.id AS member_id')                        
            ->where('student_sessions.session_id',get_option('academic_year'))
            ->where('student_sessions.class_id',$class)
            ->where('users.user_type','Student')
            ->orderBy('students.id', 'DESC')
            ->get();                            
        }else{
            $students = [];
            $class = '';
        }     
        return view('backend.hostel.members.member-list',compact('students','class'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id)
    {
        return view('backend.hostel.members.modal.member-add',compact('id'));
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
            'student_id' => 'required',
            'hostel_id' => 'required',
            'hostel_category_id' => 'required',
        ]);

        $member = new HostelMember();
        $member->student_id = $request->student_id;
        $member->hostel_id = $request->hostel_id;
        $member->hostel_category_id = $request->hostel_category_id;
        $member->save();

        return back()->with('success', _lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::join('users','users.id','=','students.user_id')
                     ->join('student_sessions','students.id','=','student_sessions.student_id')
                     ->join('classes','classes.id','=','student_sessions.class_id')
                     ->join('sections','sections.id','=','student_sessions.section_id')
                     ->join('parents','parents.id','=','students.parent_id')
                     ->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('students.id',$id)->first();
        return view('backend.students.student-view',compact('student')); //use student's view file
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = HostelMember::select('*','hostel_members.id AS id')
                                ->join('hostel_categories','hostel_categories.id','=','hostel_members.hostel_category_id')
                                ->where('hostel_members.id',$id)
                                ->first();
        return view('backend.hostel.members.modal.member-edit',compact('member'));
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
        $this->validate($request, [
            'hostel_id' => 'required',
            'hostel_category_id' => 'required',
        ]);

        $member = HostelMember::find($id);
        $member->hostel_id = $request->hostel_id;
        $member->hostel_category_id = $request->hostel_category_id;
        $member->save();

        return back()->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = HostelMember::find($id);
        $member->delete();

        return back()->with('success', _lang('Information has been deleted'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_standard(Request $request)
    {
        $results = HostelCategory::where('hostel_id',$request->hostel_id)->orderBy('id', 'DESC')->get();
        $standards = '';
        $standards .= '<option value="">Select One</option>';
        foreach($results as $data){
            $standards .= '<option value="'.$data->id.'">'.$data->standard.'</option>';
        }
        return $standards;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_hostel_fee(Request $request)
    {
        $hostel_fee = HostelCategory::find($request->hostel_category_id)->hostel_fee;
        return $hostel_fee;
    }
}
