<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhoneCallLog;

class PhoneCallLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('frontoffice/phone_call_logs');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.frontoffice.phone_call_logs.create');
        }else{
           return view('backend.frontoffice.phone_call_logs.modal.create');
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'call_type' => 'required|string|max:30',
            'date' => 'required',
            'note' => 'nullable|string|max:250',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect('phone_call_logs/create')
                            ->withErrors($validator)
                            ->withInput();
            }           
        }
        
    
        $phone_call_log = new PhoneCallLog();
        $phone_call_log->session_id = get_option('academic_year');
        $phone_call_log->name = $request->name;
        $phone_call_log->phone = $request->phone;
        $phone_call_log->call_type = $request->call_type;
        $phone_call_log->date = $request->date;
        $phone_call_log->start_time = $request->start_time;
        $phone_call_log->end_time = $request->end_time;
        $phone_call_log->note = $request->note;
        $phone_call_log->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/phone_call_logs')->with('success', _lang('Information has been added sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store_with_redirect','message'=>_lang('Information has been added sucessfully'),'data'=>$phone_call_log]);
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
        $phone_call_log = PhoneCallLog::find($id);
        if( ! $request->ajax()){
           return view('backend.frontoffice.phone_call_logs.modal.show',compact('phone_call_log'));
        }else{
           return view('backend.frontoffice.phone_call_logs.modal.show',compact('phone_call_log'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $phone_call_log = PhoneCallLog::find($id);
        if( ! $request->ajax()){
           return view('backend.frontoffice.phone_call_logs.edit',compact('phone_call_log'));
        }else{
           return view('backend.frontoffice.phone_call_logs.modal.edit',compact('phone_call_log'));
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'call_type' => 'required|string|max:30',
            'date' => 'required',
            'note' => 'nullable|string|max:250',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }
    
        $phone_call_log = PhoneCallLog::find($id);
        $phone_call_log->name = $request->name;
        $phone_call_log->phone = $request->phone;
        $phone_call_log->call_type = $request->call_type;
        $phone_call_log->date = $request->date;
        $phone_call_log->start_time = $request->start_time;
        $phone_call_log->end_time = $request->end_time;
        $phone_call_log->note = $request->note;
        $phone_call_log->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/phone_call_logs')->with('success', _lang('Information has been updated sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'update_with_redirect','message'=>_lang('Information has been updated sucessfully'),'data'=>$phone_call_log]);
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
        $phone_call_log = PhoneCallLog::find($id);
        $phone_call_log->delete();
        return redirect('frontoffice/phone_call_logs')->with('success', _lang('Information has been deleted'));
    }
}
