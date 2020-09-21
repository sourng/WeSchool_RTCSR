<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all()->sortByDesc("id");
        return view('backend.administration.permission_role.list',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.administration.permission_role.create');
		}else{
           return view('backend.administration.permission_role.modal.create');
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
			'role_name' => 'required|max:191',
		'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('permission_roles/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			
	    
		
        $role= new Role();
	    $role->role_name = $request->input('role_name');
	$role->note = $request->input('note');
	
        $role->save();
        
		if(! $request->ajax()){
           return redirect('permission_roles/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$role]);
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
        $role = Role::find($id);
		if(! $request->ajax()){
		    return view('backend.administration.permission_role.view',compact('role','id'));
		}else{
			return view('backend.administration.permission_role.modal.view',compact('role','id'));
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
        $role = Role::find($id);
		if(! $request->ajax()){
		   return view('backend.administration.permission_role.edit',compact('role','id'));
		}else{
           return view('backend.administration.permission_role.modal.edit',compact('role','id'));
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
			'role_name' => 'required|max:191',
		'note' => ''
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('permission_roles.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $role = Role::find($id);
		$role->role_name = $request->input('role_name');
	$role->note = $request->input('note');
	
        $role->save();
		
		if(! $request->ajax()){
           return redirect('permission_roles')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$role]);
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
        $role = Role::find($id);
        $role->delete();
        return redirect('permission_roles')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
