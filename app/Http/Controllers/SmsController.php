<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use App\SmsLog;
use Validator;
use Auth;

class SmsController extends Controller
{
	public function create()
    {
        return view('backend.sms.create');
    }
	
	public function logs()
    {
        $messages = SmsLog::join("users","sms_logs.sender_id","=","users.id")
					 ->select('sms_logs.*','users.name as sender')
		             ->orderBy("sms_logs.id","DESC")->paginate(15);
         return view('backend.sms.logs',compact('messages'));
    }
	
    public function send(Request $request)
    {
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);
		
		
		$this->validate($request, [
            'body' => 'required|max:300',
			'user_id' => 'required_without:student_id',
			'student_id' => 'required_without:user_id',
        ]);
		
		$body = strip_tags($request->input("body"));
		
        $accountSid = get_option("TWILIO_SID");
        $authToken  = get_option("TWILIO_TOKEN");
        $mobileNumber = get_option("TWILIO_MOBILE");
        $client = new Client($accountSid, $authToken);
        try
        {
			if($request->input('user_id') != ""){
				if($request->input('user_id') == "all"){
				   foreach( $request->input('users') as $mobile_number ){
					  if( Auth::user()->phone == $mobile_number || $mobile_number == ""){
						  continue;
					  }
					    $client->messages->create(
							$mobile_number,
							array(
								 'from' => $mobileNumber,
								 'body' => $body
							 )
						);
						
						$log = new SmsLog();
						$log->receiver = $mobile_number;
						$log->message = $body;
						$log->sender_id = Auth::user()->id;
						$log->save();
				   }
				}else{
				   if( Auth::user()->phone != $request->input('user_id') || $request->input('user_id') != ""){
					   $client->messages->create(
							$request->input('user_id'),
							array(
								 'from' => $mobileNumber,
								 'body' => $body
							 )
						);
						
						$log = new SmsLog();
						$log->receiver = $request->input('user_id');
						$log->message = $body;
						$log->sender_id = Auth::user()->id;
						$log->save();
				   }else{
					   return redirect('sms/compose')->with('error', _lang('Invalid mobile number Or Illegal Operation !'))->withInput();
				   }
				   
				}
			}
			
			if($request->input('student_id') != ""){
				if($request->input('student_id') == "all"){
				   foreach( $request->input('users') as $mobile_number ){
					  if( Auth::user()->phone == $mobile_number || $mobile_number == ""){
						  continue;
					  }
					  $client->messages->create(
							$mobile_number,
							array(
								 'from' => $mobileNumber,
								 'body' => $body
							 )
					  );
					  
						$log = new SmsLog();
						$log->receiver = $mobile_number;
						$log->message = $body;
						$log->sender_id = Auth::user()->id;
						$log->save();
				   }
				}else{
				   if( Auth::user()->phone != $request->input('student_id') || $request->input('student_id') != "" ){	
						$client->messages->create(
							$request->input('student_id'),
							array(
								 'from' => $mobileNumber,
								 'body' => $body
							 )
						);
						
						$log = new SmsLog();
						$log->receiver = $request->input('student_id');
						$log->message = $body;
						$log->sender_id = Auth::user()->id;
						$log->save();
				   }else{
					   return redirect('message/compose')->with('error', _lang('Invalid mobile number Or Illegal Operation !'))->withInput();
				   }
				}
			}
			
			return redirect()->back()->with('success', _lang('Message Send Sucessfully.'));
		
		}catch (Exception $e){
			return redirect()->back()->with('error', $e->getMessage());
        }
    }
}