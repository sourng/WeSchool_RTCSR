<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Department;
use App\Designation;
use Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::orderBy('id', 'DESC')->get();
        return view('backend.departments.index', compact('departments'));
    }
	

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		    return view('backend.departments.create');
		}else{
            return view('backend.departments.modal.create');
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
		
		$validator = Validator::make($request->all(), [
			
            'department' => 'required|string|max:191',
            'designation'    => "required|array|min:1",
            'designation.*'  => 'required|string|distinct|min:3',

		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error', 'message'=>$validator->errors()->all()]);
			}else{
				return back()->withErrors($validator)->withInput();
			}			
		}
		
	
        $department = new Department();
        $department->department = $request->department;
        $department->save();

        for ($i=0; $i < count($request->designation); $i++) { 
            $designation = new Designation();
            $designation->department_id = $department->id;
            $designation->designation = $request->designation[$i];
            $designation->save();
        }
        
		if(! $request->ajax()){
            return back()->with('success', _lang('Information has been added sucessfully'));
        }else{
		    return response()->json(['result'=>'success', 'redirect'=> url('departments'), 'message'=>_lang('Information has been added sucessfully'),'data'=>$department]);
		}
        
    }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $department = Department::find($id);
		if(! $request->ajax()){
		    return view('backend.departments.show', compact('department'));
		}else{
			return view('backend.departments.modal.show', compact('department'));
		} 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function departments_options(Request $request, $department_id)
    {
        $designations = Designation::where('department_id', $department_id)->get();

        $option = '';
        foreach ($designations as $data) {
            $option .= '<option value="' . $data->id . '">' . $data->designation . '</option>';
        }
        return $option;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $department = Department::find($id);
		if(! $request->ajax()){
		    return view('backend.departments.edit', compact('department'));
		}else{
			return view('backend.departments.modal.edit', compact('department'));
		}  
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
	
		$validator = Validator::make($request->all(), [
			
            'department' => 'required|string|max:191',
            'designation'    => "required|array|min:1",
            'designation.*'  => 'required|string|distinct|min:3',
            'status' => 'required',

		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error', 'message'=>$validator->errors()->all()]);
			}else{
				return back()->withErrors($validator)->withInput();
			}			
		}
		
	
        $department = Department::find($id);
        $department->department = $request->department;
        $department->status = $request->status;
        $department->save();

        for ($i=0; $i < count($request->designation); $i++) {
            if($request->designation_id[$i] != ''){
                $designation = Designation::find($request->designation_id[$i]);
            }else{
                $designation = new Designation();
            }
            $designation->department_id = $department->id;
            $designation->designation = $request->designation[$i];
            $designation->save();
        }
		
		if(! $request->ajax()){
            return redirect('departments')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		    return response()->json(['result'=>'success', 'redirect'=> url('departments'), 'message'=>_lang('Information has been updated sucessfully'),'data'=>$department]);
		}
	    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $department = Department::find($id);
        $department->delete();

        foreach (Designation::where('department_id', $id)->get() as $designation) {
            $designation->delete();
        }

        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been deleted'));
        }else{
            return response()->json(['result'=>'success','message'=>_lang('Information has been deleted')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function designation_destroy(Request $request, $id)
    {
        $designation = Designation::find($id);
        $designation->delete();

        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been deleted'));
        }else{
            return response()->json(['result'=>'success','message'=>_lang('Information has been deleted')]);
        }
    }
}
