<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assignment;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignments = Assignment::select('*','assignments.id AS id')
                            ->join('classes','classes.id','=','assignments.class_id')
                            ->join('sections','sections.id','=','assignments.class_id')
                            ->join('subjects','subjects.id','=','assignments.class_id')
                            ->where('assignments.session_id', get_option('academic_year'))
                            ->orderBy('assignments.id', 'DESC')
                            ->get();
        return view('backend.assignments.assignment-list',compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.assignments.assignment-add');
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
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'file' => 'required|mimes:doc,pdf,docx,zip',
            'file_2' => 'nullable|mimes:doc,pdf,docx,zip',
            'file_3' => 'nullable|mimes:doc,pdf,docx,zip',
            'file_4' => 'nullable|mimes:doc,pdf,docx,zip',
        ]);

        $assignment = new Assignment();
        $assignment->session_id = get_option("academic_year");
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->deadline = $request->deadline;
        $assignment->class_id = $request->class_id;
        $assignment->section_id = $request->section_id;
        $assignment->subject_id = $request->subject_id;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file = $file_name;
        }
        if($request->hasFile('file_2')){
            $file = $request->file('file_2');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_2 = $file_name;
        }
        if($request->hasFile('file_3')){
            $file = $request->file('file_3');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_3 = $file_name;
        }
        if($request->hasFile('file_4')){
            $file = $request->file('file_4');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_4 = $file_name;
        }

        $assignment->save();

        return redirect('assignments')->with('success', _lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::select('*','assignments.id AS id')
                            ->join('classes','classes.id','=','assignments.class_id')
                            ->join('sections','sections.id','=','assignments.class_id')
                            ->join('subjects','subjects.id','=','assignments.class_id')
                            ->where('assignments.id',$id)
							->where('assignments.session_id', get_option('academic_year'))
                            ->first();

        return view('backend.assignments.assignment-show',compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignment = Assignment::where("id",$id)
		                        ->where('assignments.session_id', get_option('academic_year'))->first();

        return view('backend.assignments.assignment-edit',compact('assignment'));
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
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'file' => 'nullable|mimes:doc,pdf,docx,zip',
            'file_2' => 'nullable|mimes:doc,pdf,docx,zip',
            'file_3' => 'nullable|mimes:doc,pdf,docx,zip',
            'file_4' => 'nullable|mimes:doc,pdf,docx,zip',
        ]);

        $assignment = Assignment::find($id);
		$assignment->session_id = get_option("academic_year");
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->deadline = $request->deadline;
        $assignment->class_id = $request->class_id;
        $assignment->section_id = $request->section_id;
        $assignment->subject_id = $request->subject_id;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file = $file_name;
        }
        if($request->hasFile('file_2')){
            $file = $request->file('file_2');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_2 = $file_name;
        }
        if($request->hasFile('file_3')){
            $file = $request->file('file_3');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_3 = $file_name;
        }
        if($request->hasFile('file_4')){
            $file = $request->file('file_4');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/assignments/'),$file_name);
            $assignment->file_4 = $file_name;
        }

        $assignment->save();

        return redirect('assignments')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignment = Assignment::find($id);
        $assignment->delete();

        return redirect('assignments')->with('success', _lang('Information has been deleted'));
    }
}
