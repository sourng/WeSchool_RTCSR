<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Section;
use App\ClassModel;
use App\User;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class = "")
    {
		$sections = array();
		if($class != ""){
			$sections = Section::select('*','sections.id AS id','teachers.name as teacher_name')
									->join('teachers','teachers.id','=','sections.class_teacher_id')
									->join('classes','classes.id','=','sections.class_id')
									->where('sections.class_id', $class)
									->orderBy('sections.rank', 'ASC')
									->get();
		}						
        return view('backend.sections.section-add',compact('sections','class'));
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
            'section_name' => 'required|string|max:191',
            'class_id' => 'required',
            'class_teacher_id' => 'required|unique:sections',
            'room_no' => 'required|max:100',
			'capacity' => 'required|numeric',
            'rank' =>  Rule::unique('sections')->where(function ($query) {
				global $request;
				return $query->where('class_id', $request->class_id);
			})
			
        ]);

        $section = new Section();
        $section->section_name = $request->section_name;
        $section->class_id = $request->class_id;
        $section->class_teacher_id = $request->class_teacher_id;
        $section->room_no = $request->room_no;
        $section->rank = $request->rank;
        $section->capacity = $request->capacity;
        $section->save();
        return redirect('sections')->with('success', _lang('Information has been added'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_section(Request $request)
    {
        $results = Section::where('class_id',$request->class_id)->get();
        $sections = '';
        $sections .= '<option value="">'._lang('Select One').'</option>';
        foreach($results as $data){
            $sections .= '<option value="'.$data->id.'">'.$data->section_name.'</option>';
        }
        return $sections;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::select('*','sections.id AS id')
                                ->join('classes','classes.id','=','sections.class_id')
                                ->where('sections.id',$id)
                                ->first();
        return view('backend.sections.section-edit',compact('section'));
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
            'section_name' => 'required|string|max:191',
            'class_id' => 'required',
			'class_teacher_id' => [
				'required',
				Rule::unique('sections')->ignore($id),
			],
			'room_no' => 'required|max:100',
			'capacity' => 'required|numeric',
            'rank' =>  Rule::unique('sections')->where(function ($query) {
				global $request, $id;
				return $query->where('class_id', $request->class_id);
			})->ignore($id)
        ]);

        $section = Section::find($id);
        $section->section_name = $request->section_name;
        $section->class_id = $request->class_id;
        $section->class_teacher_id = $request->class_teacher_id;
		$section->room_no = $request->room_no;
        $section->rank = $request->rank;
		$section->capacity = $request->capacity;
        $section->save();
        return redirect('sections')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);
        $section->delete();
        return redirect('sections')->with('success', _lang('Information has been deleted'));
    }
}
