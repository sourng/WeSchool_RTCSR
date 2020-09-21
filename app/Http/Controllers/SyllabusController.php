<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Syllabus;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $syllabus = Syllabus::select('*','syllabus.id AS id')
                            ->join('classes','classes.id','=','syllabus.class_id')
                            ->where('syllabus.session_id', get_option('academic_year'))
							->orderBy('syllabus.id', 'DESC')
                            ->get();
        return view('backend.syllabus.syllabus-list',compact('syllabus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.syllabus.syllabus-add');
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
            'class_id' => 'required',
            'file' => 'required|mimes:doc,pdf,docx,zip',
        ]);

        $syllabus = New Syllabus();
		$syllabus->session_id = get_option("academic_year");
        $syllabus->title = $request->title;
        $syllabus->description = $request->description;
        $syllabus->class_id = $request->class_id;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/syllabus/'),$file_name);
            $syllabus->file = $file_name;
        }

        $syllabus->save();

        return redirect('syllabus')->with('success', _lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $syllabus = Syllabus::select('*','syllabus.id AS id')
                            ->join('classes','classes.id','=','syllabus.class_id')
                            ->where('syllabus.id',$id)
							->where("syllabus.session_id",get_option('academic_year'))
                            ->first();
        return view('backend.syllabus.syllabus-view',compact('syllabus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $syllabus = Syllabus::where("id",$id)
							->where("session_id",get_option('academic_year'))->first();
        return view('backend.syllabus.syllabus-edit',compact('syllabus'));
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
            'class_id' => 'required',
            'file' => 'nullable|mimes:doc,pdf,docx,zip',
        ]);

        $syllabus = Syllabus::find($id);
		$syllabus->session_id = get_option("academic_year");
        $syllabus->title = $request->title;
        $syllabus->description = $request->description;
        $syllabus->class_id = $request->class_id;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = time().'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/syllabus/'),$file_name);
            $syllabus->file = $file_name;
        }

        $syllabus->save();

        return redirect('syllabus')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $syllabus=Syllabus::find($id);
        $syllabus->delete();

        return redirect('syllabus')->with('success', _lang('Information has been deleted'));
    }
}
