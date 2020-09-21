<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransportMember;
use App\Section;
use App\Student;
use App\Teacher;
use App\User;
use App\Transport;
use Validator;

class TransportMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = '',$class = '')
    {
        if($type == 'students'){
            $members = TransportMember::select('*','student_sessions.roll','classes.class_name','sections.section_name','transport_members.id as id')
                            ->join('users','users.id','=','transport_members.user_id')
                            ->join('students','students.user_id','=','transport_members.user_id')
                            ->join('transports','transports.id','=','transport_members.transport_id')
                            ->join('transport_vehicles','transport_vehicles.id','=','transports.vehicle_id')
                            ->join('student_sessions','students.id','=','student_sessions.student_id')
                            ->join('classes','classes.id','=','student_sessions.class_id')
                            ->join('sections','sections.id','=','student_sessions.section_id')
                            ->where('student_sessions.session_id',get_option('academic_year'))
                            ->where('student_sessions.class_id',$class)
                            ->where('users.user_type','Student')
                            ->orderBy('transport_members.id', 'DESC')
                            ->get();
                            
            return view('backend.transport.members.member-students-list',compact('members','type','class'));
        }elseif($type == 'teachers'){
            $members = TransportMember::select('*','transport_members.id AS id')
                                    ->join('users','users.id','=','transport_members.user_id')
                                    ->join('transports','transports.id','=','transport_members.transport_id')
                                    ->join('transport_vehicles','transport_vehicles.id','=','transports.vehicle_id')
                                    ->where('user_type','Teacher')
                                    ->orderBy('transport_members.id', 'DESC')
                                    ->get();
            return view('backend.transport.members.member-teachers-list',compact('members','type'));
        }else{
            $members = [];
            return view('backend.transport.members.member-index-list',compact('members'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::orderBy('id', 'DESC')->get();
        return view('backend.transport.members.member-add',compact('teachers'));
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
            'user_id' => 'required|unique:transport_members',
            'transport_id' => 'required',
        ]);
        $member = New TransportMember();
        $member->user_id = $request->user_id;
        $member->member_type = $request->member_type;
        $member->transport_id = $request->transport_id;
        $member->save();

        return redirect('transportmembers')->with('success',_lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find = TransportMember::find($id);
        $user_id = User::find($find->user_id)->id;
        if($find->member_type == 'Student'){
            $id = Student::where('user_id',$user_id)->first()->id;
            return redirect('students/'.$id);
        }else{
            $id = Teacher::where('user_id',$user_id)->first()->id;
            return redirect('teachers/'.$id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = TransportMember::find($id);
        $member->delete();
        return redirect('transportmembers')->with('success',_lang('Information has been deleted'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_section(Request $request)
    {
        $results = Section::where('class_id',$request->class_id)->orderBy('id', 'DESC')->get();
        $sections = '';
        $sections .= '<option value="">Select One</option>';
        foreach($results as $data){
            $sections .= '<option value="'.$data->id.'">'.$data->section_name.'</option>';
        }
        return $sections;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_student(Request $request)
    {
        $results = Student::join('student_sessions','student_sessions.student_id',
            '=','students.id')
                            ->join('sections','sections.id','=','student_sessions.section_id')
                            ->where('student_sessions.session_id',get_option('academic_year'))
                            ->where('student_sessions.section_id',$request->section_id)
                            ->orderBy('students.id', 'DESC')
                            ->get();
        $students = '';
        $students .= '<option value="">Select One</option>';
        foreach($results as $data){
            $students .= '<option value="'.$data->user_id.'">'.$data->first_name.' '.$data->last_name.'</option>';
        }
        return $students;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_transport_fee(Request $request)
    {
        $transport = Transport::find($request->transport_id)->road_fare;
        return $transport;
    }
}
