<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LibraryMember;
use App\Section;
use App\Student;
use App\Teacher;
use App\User;
use Validator;

class LibraryMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $members = LibraryMember::select('*','library_members.id AS id')->join('users','users.id','=','library_members.user_id')->orderBy('library_members.id', 'DESC')->get();
        return view('backend.library.members.member-list',compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::orderBy('id', 'DESC')->get();
        return view('backend.library.members.member-add',compact('teachers'));
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
            'user_id' => 'required|unique:library_members',
        ]);
        if ($validator->fails()) { 
            return back()->withErrors($validator)->withInput();
        }

        $member = New LibraryMember();
        $member->user_id = $request->user_id;
        $member->library_id = date('Y').rand(100,999).sprintf("%02d", $request->user_id);
        $member->member_type = $request->member_type;
        $member->save();

        return redirect('librarymembers/librarycard/'.$member->id)->with('success',_lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find = LibraryMember::find($id);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function library_card($id)
    {
        $library = LibraryMember::join('users','users.id','=','library_members.user_id')
								->where('library_members.id',$id)->first();
        return view('backend.library.members.library-card',compact('library'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = LibraryMember::find($id);
        $member->delete();
        return redirect('librarymembers')->with('success', _lang('Information has been deleted'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_section(Request $request)
    {
        $results = Section::where('class_id',$request->class_id)->orderBy('id', 'DESC')->get();
        $sections = '';
        $sections .= '<option value="">'._lang('Select One').'</option>';
        foreach($results as $data){
            $sections .= '<option value="'.$data->id.'">'.$data->section_name.'</option>';
        }
        return $sections;
    }


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
        $students .= '<option value="">'._lang('Select One').'</option>';
        foreach($results as $data){
            $students .= '<option value="'.$data->user_id.'">'.$data->first_name.' '.$data->last_name.'</option>';
        }
        return $students;
    }
}
