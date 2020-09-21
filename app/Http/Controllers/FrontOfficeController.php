<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdmissionEnquiry;
use App\VisitorInformation;
use App\PhoneCallLog;
use App\Complain;
use App\Picklist;

class FrontOfficeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = '', $type = '')
    {
    	$admission_enquiries = AdmissionEnquiry::where('session_id',get_option('academic_year'))
                                                ->orderBy('id','DESC')
                                                ->get();
    	$visitor_informations = VisitorInformation::where('session_id',get_option('academic_year'))
                                                    ->orderBy('id','DESC')
                                                    ->get();
    	$phone_call_logs = PhoneCallLog::where('session_id',get_option('academic_year'))
                                        ->orderBy('id','DESC')
                                        ->get();
    	$complains = Complain::where('session_id',get_option('academic_year'))
                                ->orderBy('id','DESC')
                                ->get();
        if($type == ''){
            $picklists = Picklist::whereIn('type', ['Source', 'Reference', 'Purpose', 'Complain'])->orderBy('id', 'desc')->get();
        }else{
            $picklists = Picklist::where('type', $type)->orderBy('id', 'desc')->get();
        }
        
        return view('backend.frontoffice.index',compact('page','admission_enquiries','visitor_informations','phone_call_logs','complains', 'type', 'picklists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.frontoffice.settings.create');
        }else{
           return view('backend.frontoffice.settings.modal.create');
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
        $picklist = Picklist::find($id);
        if(! $request->ajax()){
           return view('backend.frontoffice.settings.edit',compact('picklist','id'));
        }else{
           return view('backend.frontoffice.settings.modal.edit',compact('picklist','id'));
        }  
    }
}
