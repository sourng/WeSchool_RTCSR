<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VisitorInformation;

class VisitorInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('frontoffice/visitor_informations');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.frontoffice.visitor_informations.create');
        }else{
           return view('backend.frontoffice.visitor_informations.modal.create');
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
            'purpose' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'date' => 'required',
            'id_card' => 'nullable|string|max:50',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect('visitor_informations/create')
                            ->withErrors($validator)
                            ->withInput();
            }           
        }
        
    
        $visitor_information = new VisitorInformation();
        $visitor_information->session_id = get_option('academic_year');
        $visitor_information->purpose = $request->purpose;
        $visitor_information->name = $request->name;
        $visitor_information->phone = $request->phone;
        $visitor_information->date = $request->date;
        $visitor_information->in_time = $request->in_time;
        $visitor_information->out_time = $request->out_time;
        $visitor_information->number_of_person = $request->number_of_person;
        $visitor_information->id_card = $request->id_card;
        $visitor_information->note = $request->note;
        $visitor_information->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/visitor_informations')->with('success', _lang('Information has been added sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store_with_redirect','message'=>_lang('Information has been added sucessfully'),'data'=>$visitor_information]);
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
        $visitor_information = VisitorInformation::find($id);
        if( ! $request->ajax()){
           return view('backend.frontoffice.visitor_informations.modal.show',compact('visitor_information'));
        }else{
           return view('backend.frontoffice.visitor_informations.modal.show',compact('visitor_information'));
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
        $visitor_information = VisitorInformation::find($id);
        if( ! $request->ajax()){
           return view('backend.frontoffice.visitor_informations.edit',compact('visitor_information'));
        }else{
           return view('backend.frontoffice.visitor_informations.modal.edit',compact('visitor_information'));
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
            'purpose' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'date' => 'required',
            'id_card' => 'nullable|string|max:50',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }
    
        $visitor_information = VisitorInformation::find($id);
        $visitor_information->purpose = $request->purpose;
        $visitor_information->name = $request->name;
        $visitor_information->phone = $request->phone;
        $visitor_information->date = $request->date;
        $visitor_information->in_time = $request->in_time;
        $visitor_information->out_time = $request->out_time;
        $visitor_information->number_of_person = $request->number_of_person;
        $visitor_information->id_card = $request->id_card;
        $visitor_information->note = $request->note;
        $visitor_information->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/visitor_informations')->with('success', _lang('Information has been updated sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'update_with_redirect','message'=>_lang('Information has been updated sucessfully'),'data'=>$visitor_information]);
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
        $visitor_information = VisitorInformation::find($id);
        $visitor_information->delete();
        return redirect('frontoffice/visitor_informations')->with('success', _lang('Information has been deleted'));
    }
}
