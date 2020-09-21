<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdmissionEnquiry;
class AdmissionEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('frontoffice/admission_enquiries');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.frontoffice.admission_enquiries.create');
        }else{
           return view('backend.frontoffice.admission_enquiries.modal.create');
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:250',
            'description' => 'nullable|string|max:250',
            'date' => 'required',
            'reference' => 'nullable|string|max:20',
            'source' => 'required|string|max:20',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect('admission_enquiries/create')
                            ->withErrors($validator)
                            ->withInput();
            }           
        }
        
    
        $admission_enquiry = new AdmissionEnquiry();
        $admission_enquiry->session_id = get_option('academic_year');
        $admission_enquiry->first_name = $request->first_name;
        $admission_enquiry->last_name = $request->last_name;
        $admission_enquiry->phone = $request->phone;
        $admission_enquiry->email = $request->email;
        $admission_enquiry->address = $request->address;
        $admission_enquiry->description = $request->description;
        $admission_enquiry->date = $request->date;
        $admission_enquiry->next_follow_up_date = $request->next_follow_up_date;
        $admission_enquiry->reference = $request->reference;
        $admission_enquiry->source = $request->source;
        $admission_enquiry->class_id = $request->class_id;
        $admission_enquiry->number_of_child = $request->number_of_child;
        $admission_enquiry->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/admission_enquiries')->with('success', _lang('Information has been added sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store_with_redirect','message'=>_lang('Information has been added sucessfully'),'data'=>$admission_enquiry]);
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
        $admission_enquiry = AdmissionEnquiry::select('*','admission_enquiries.id AS id')
                                                ->leftJoin('classes',function($join) {
                                                    $join->on('classes.id','=','class_id');
                                                })
                                                ->where('admission_enquiries.id','=',$id)
                                                ->first();
        if( ! $request->ajax()){
           return view('backend.frontoffice.admission_enquiries.show',compact('admission_enquiry'));
        }else{
           return view('backend.frontoffice.admission_enquiries.modal.show',compact('admission_enquiry'));
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
        $admission_enquiry = AdmissionEnquiry::find($id);
        if( ! $request->ajax()){
           return view('backend.frontoffice.admission_enquiries.modal.edit',compact('admission_enquiry'));
        }else{
           return view('backend.frontoffice.admission_enquiries.modal.edit',compact('admission_enquiry'));
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:250',
            'description' => 'nullable|string|max:250',
            'date' => 'required',
            'reference' => 'nullable|string|max:20',
            'source' => 'required|string|max:20',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }
        
    
        $admission_enquiry = AdmissionEnquiry::find($id);
        $admission_enquiry->first_name = $request->first_name;
        $admission_enquiry->last_name = $request->last_name;
        $admission_enquiry->phone = $request->phone;
        $admission_enquiry->email = $request->email;
        $admission_enquiry->address = $request->address;
        $admission_enquiry->description = $request->description;
        $admission_enquiry->date = $request->date;
        $admission_enquiry->next_follow_up_date = $request->next_follow_up_date;
        $admission_enquiry->reference = $request->reference;
        $admission_enquiry->source = $request->source;
        $admission_enquiry->class_id = $request->class_id;
        $admission_enquiry->number_of_child = $request->number_of_child;
        $admission_enquiry->save();
        
        if(! $request->ajax()){
           return redirect('frontoffice/admission_enquiries')->with('success', _lang('Information has been updated sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'update_with_redirect','message'=>_lang('Information has been updated sucessfully'),'data'=>$admission_enquiry]);
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
        $admission_enquiry = AdmissionEnquiry::find($id);
        $admission_enquiry->delete();
        return redirect('frontoffice/admission_enquiries')->with('success', _lang('Information has been deleted'));
    }
}
