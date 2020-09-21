<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $class='' )
    {
        $subjects = Subject::select('*','subjects.id AS id')
                        ->join('classes','classes.id','=','subjects.class_id')
                        ->where('subjects.class_id', $class)
						->orderBy('subjects.id', 'DESC')
                        ->get();
        return view('backend.subjects.subject-list',compact('subjects','class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('backend.subjects.subject-add');
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
            'subject_name' => 'required|string|max:191',
            'subject_code' => 'required|string|max:191',
            'subject_type' => 'required',
            'class_id' => 'required',
			'full_mark' => 'required|integer',
            'pass_mark' => 'required|integer'
        ]);

        $subject = New Subject();
        $subject->subject_name = $request->subject_name;
        $subject->subject_code = $request->subject_code;
        $subject->subject_type = $request->subject_type;
        $subject->class_id = $request->class_id;
        $subject->full_mark = $request->full_mark;
        $subject->pass_mark = $request->pass_mark;
        $subject->save();
        return redirect('subjects/create')->with('success',_lang('Information has been added'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_subject(Request $request)
    {
        $results = Subject::where('class_id',$request->class_id)->orderBy('id', 'DESC')->get();
        $subjects = '';
        $subjects .= '<option value="">Select One</option>';
        foreach($results as $data){
            $subjects .= '<option value="'.$data->id.'">'.$data->subject_name.'</option>';
        }
        return $subjects;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::find($id);
        return view('backend.subjects.subject-edit',compact('subject'));
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
            'subject_name' => 'required|string|max:191',
            'subject_code' => 'required|string|max:191',
            'subject_type' => 'required',
            'class_id' => 'required',
            'full_mark' => 'required|integer',
            'pass_mark' => 'required|integer'
        ]);

        $subject = Subject::find($id);
        $subject->subject_name = $request->subject_name;
        $subject->subject_code = $request->subject_code;
        $subject->subject_type = $request->subject_type;
        $subject->class_id = $request->class_id;
		$subject->full_mark = $request->full_mark;
        $subject->pass_mark = $request->pass_mark;
        $subject->save();
        return redirect('subjects')->with('success',_lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
        $subject->delete();
        return redirect('subjects')->with('success',_lang('Information has been deleted'));
    }
}
