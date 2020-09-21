<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complain;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('frontoffice/complains');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.frontoffice.complains.create');
        }else{
           return view('backend.frontoffice.complains.modal.create');
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
            'complain_type' => 'required|string|max:50',
            'source' => 'nullable|string|max:50',
            'complain_by' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|string|max:100',
            'taken_action' => 'nullable|string|max:250',
            'note' => 'nullable|string|max:250',
            'date' => 'required',
            'attach_document' => 'nullable|nullable|mimes:doc,pdf,docx,zip,png,jpg,jpeg',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect('complains/create')
                            ->withErrors($validator)
                            ->withInput();
            }           
        }
        
    
        $complain = new Complain();
        $complain->session_id = get_option('academic_year');
        $complain->complain_type = $request->complain_type;
        $complain->source = $request->source;
        $complain->complain_by = $request->complain_by;
        $complain->phone = $request->phone;
        $complain->email = $request->email;
        $complain->date = $request->date;
        $complain->taken_action = $request->taken_action;
        $complain->note = $request->note;
        if($request->hasFile('attach_document')){
            $file = $request->file('attach_document');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/complains/'),$file_name);
            $complain->attach_document = $file_name;
        }
        $complain->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/complains')->with('success', _lang('Information has been added sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store_with_redirect','message'=>_lang('Information has been added sucessfully'),'data'=>$complain]);
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
        $complain = Complain::find($id);
        if( ! $request->ajax()){
           return view('backend.frontoffice.complains.modal.show',compact('complain'));
        }else{
           return view('backend.frontoffice.complains.modal.show',compact('complain'));
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
        $complain = Complain::find($id);
        if( ! $request->ajax()){
           return view('backend.frontoffice.complains.edit',compact('complain'));
        }else{
           return view('backend.frontoffice.complains.modal.edit',compact('complain'));
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
            'complain_type' => 'required|string|max:50',
            'source' => 'nullable|string|max:50',
            'complain_by' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|string|max:100',
            'taken_action' => 'nullable|string|max:250',
            'note' => 'nullable|string|max:250',
            'date' => 'required',
			'attach_document' => 'nullable|nullable|mimes:doc,pdf,docx,zip,png,jpg,jpeg',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }
    
        $complain = Complain::find($id);
        $complain->complain_type = $request->complain_type;
        $complain->source = $request->source;
        $complain->complain_by = $request->complain_by;
        $complain->phone = $request->phone;
        $complain->email = $request->email;
        $complain->date = $request->date;
        $complain->taken_action = $request->taken_action;
        $complain->note = $request->note;
		
        if($request->hasFile('attach_document')){
            $file = $request->file('attach_document');
            $file_name = time().rand(1,999).'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/complains/'),$file_name);
            $complain->attach_document = $file_name;
        }
        $complain->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/complains')->with('success', _lang('Information has been updated sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'update_with_redirect','message'=>_lang('Information has been updated sucessfully'),'data'=>$complain]);
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
        $complain = Complain::find($id);
        $complain->delete();
        return redirect('frontoffice/complains')->with('success', _lang('Information has been deleted'));
    }
}
