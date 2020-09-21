<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\LeaveType;
use Validator;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leave_types = LeaveType::orderBy('id', 'DESC')->get();
        return view('backend.leave_types.index', compact('leave_types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
            return view('backend.leave_types.create');
        }else{
            return view('backend.leave_types.modal.create');
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
            
           	'title' => 'required|string|max:100',
           	'off_type' => 'required|string|max:30',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }			
        }

        $leave_type = new LeaveType();
        
        $leave_type->title = $request->title;
        $leave_type->off_type = $request->off_type;
        $leave_type->status = 'Active';

        $leave_type->save();

        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been added sucessfully'));
        }else{
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Information has been added sucessfully'),'data' => $leave_type]);
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
        $leave_type = LeaveType::find($id);
        if(! $request->ajax()){
            return view('backend.leave_types.show', compact('leave_type'));
        }else{
            return view('backend.leave_types.modal.show', compact('leave_type'));
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
        $leave_type = LeaveType::find($id);
        if(! $request->ajax()){
            return view('backend.leave_types.edit', compact('leave_type'));
        }else{
            return view('backend.leave_types.modal.edit', compact('leave_type'));
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
            
           	'title' => 'required|string|max:100',
           	'off_type' => 'required|string|max:30',
           	'status' => 'required|string|max:30',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }			
        }

        $leave_type = LeaveType::find($id);
        
        $leave_type->title = $request->title;
        $leave_type->off_type = $request->off_type;
        $leave_type->status = $request->status;

        $leave_type->save();

        if(! $request->ajax()){
            return redirect('leave_types')->with('success', _lang('Information has been updated sucessfully'));
        }else{
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Information has been updated sucessfully'),'data' => $leave_type]);
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
        $leave_type = LeaveType::find($id);
        $leave_type->delete();
        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been deleted'));
        }else{
            return response()->json(['result'=>'success','message'=>_lang('Information has been deleted')]);
        }
    }
}
