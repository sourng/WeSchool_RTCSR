<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcademicYear;
use Validator;
use Illuminate\Validation\Rule;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academicyears=AcademicYear::all()->sortByDesc("id");
        return view('backend.administration.academic_year.list',compact('academicyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.administration.academic_year.create');
		}else{
           return view('backend.administration.academic_year.modal.create');
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
			'session' => 'required|max:50',
			'year' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('academic_years/create')
							->withErrors($validator)
							->withInput();
			}			
		}
		
		
	    
		
        $academicyear= new AcademicYear();
	    $academicyear->session = $request->input('session');
		$academicyear->year = $request->input('year');
	
        $academicyear->save();
        
		if(! $request->ajax()){
           return redirect('academic_years')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$academicyear]);
		}
        
   }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $academicyear = AcademicYear::find($id);
		if(! $request->ajax()){
		    return view('backend.administration.academic_year.view',compact('academicyear','id'));
		}else{
			return view('backend.administration.academic_year.modal.view',compact('academicyear','id'));
		} 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $academicyear = AcademicYear::find($id);
		if(! $request->ajax()){
		   return view('backend.administration.academic_year.edit',compact('academicyear','id'));
		}else{
           return view('backend.administration.academic_year.modal.edit',compact('academicyear','id'));
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
			'session' => 'required|max:50',
			'year' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('academic_years.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $academicyear = AcademicYear::find($id);
		$academicyear->session = $request->input('session');
		$academicyear->year = $request->input('year');
	
        $academicyear->save();
		
		if(! $request->ajax()){
           return redirect('academic_years')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$academicyear]);
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
		$current_session = get_option("academic_year"); 
		if( $id == $current_session ){
			return redirect('academic_years')->with('error',_lang('Sorry, You cannot delete current Academic Session !'));
		}
        $academicyear = AcademicYear::find($id);
        $academicyear->delete();
        return redirect('academic_years')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
