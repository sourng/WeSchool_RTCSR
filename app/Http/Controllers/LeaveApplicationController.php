<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\AppliedLeave;
use App\Utilities\Overrider;
use App\Mail\DefaultMail;
use App\LeaveApplication;
use App\StaffAttendance;
use Validator;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leave_applications = LeaveApplication::orderBy('id', 'DESC')->get();
        return view('backend.leave_applications.index', compact('leave_applications'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_leave_applications()
    {
        $leave_applications = LeaveApplication::where('user_id', \Auth::user()->id)
                                            ->orderBy('id', 'DESC')
                                            ->get();
        return view('backend.leave_applications.my_leave_applications', compact('leave_applications'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
            return view('backend.leave_applications.create');
        }else{
            return view('backend.leave_applications.modal.create');
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
            
           	'date.*' => ['required', new AppliedLeave(\Auth::user()->id, $request->date)],
           	'leave_type_id.*' => 'required|numeric',
           	'absent_reason.*' => 'nullable|string|max:140',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }			
        }

        for ($i=0; $i < count($request->date); $i++) { 
            $leave_application = new LeaveApplication();
        
            $leave_application->user_id = \Auth::user()->id;
            $leave_application->date = $request->date[$i];
            $leave_application->leave_type_id = $request->leave_type_id[$i];
            $leave_application->absent_reason = $request->absent_reason[$i];

            $leave_application->save();
        }

        if(! $request->ajax()){
            return back()->with('success', _lang('Leave request has been sended sucessfully.'));
        }else{
            return response()->json(['result' => 'success', 'redirect' => url('leave_applications'), 'message' => _lang('Leave request has been sended sucessfully.')]);
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
        $leave_application = LeaveApplication::find($id);
        if(! $request->ajax()){
            return view('backend.leave_applications.show', compact('leave_application'));
        }else{
            return view('backend.leave_applications.modal.show', compact('leave_application'));
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function status($id, $status)
    {
        $leave_application = LeaveApplication::find($id);
        if($leave_application->status == 0){
            $leave_application->status = $status;
            $leave_application->save();
            if($status == 1){
                $staffAtt = new StaffAttendance();
                $staffAtt->user_id = $leave_application->user_id;
                $staffAtt->date = $leave_application->date;
                $staffAtt->attendance = 5;
                $staffAtt->save();
            }
            if($status == 1){
                $status = _lang('Approved.');
            }elseif($status == 2){
                $status = _lang('Rejected.');
            }
            $user_id = $leave_application->user_id;
            $email = $leave_application->user->email;
            return back()->with('success', _lang('Leave request has been ') . $status);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $leave_application = LeaveApplication::find($id);
        $leave_application->delete();

        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been deleted'));
        }else{
            return response()->json(['result'=>'success','message'=>_lang('Information has been deleted')]);
        }
    }
}
