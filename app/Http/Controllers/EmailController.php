<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\EmailLog;
use App\Mail\SendEmail;
use Validator;
use Auth;
use App\Utilities\Overrider;

class EmailController extends Controller
{
	public function create()
    {
        return view('backend.email.create');
    }
	
	public function logs()
    {
        $messages = EmailLog::join("users","email_logs.sender_id","=","users.id")
					 ->select('email_logs.*','users.name as sender')
		             ->orderBy("email_logs.id","DESC")->paginate(10);
         return view('backend.email.logs',compact('messages'));
    }
	
    public function send(Request $request)
    {
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);
		
		Overrider::load("Settings");

		$this->validate($request, [
            'subject' => 'required',
            'body' => 'required',
			'user_id' => 'required_without:student_id',
			'student_id' => 'required_without:user_id',
        ]);
		
		$subject = $request->input("subject");
		$body = $request->input("body");
		  
		if($request->input('user_id') != ""){
			if($request->input('user_id') == "all"){
			   foreach( $request->input('users') as $receiver_email ){
				  if( Auth::user()->email == $receiver_email || $receiver_email == ""){
					  //continue;
				  }
					//Send Email
					$mail  = new \stdClass();
					$mail->subject = $subject;
					$mail->message = $body;
					Mail::to($receiver_email)->send(new SendEmail($mail));
					
					
					$log = new EmailLog();
					$log->receiver_email = $receiver_email;
					$log->subject = $subject;
					$log->message = $body;
					$log->sender_id = Auth::user()->id;
					$log->save();
			   }
			}else{
			   if( Auth::user()->email != $request->input('user_id') || $request->input('user_id') != ""){
					//Send Email
					$mail  = new \stdClass();
					$mail->subject = $subject;
					$mail->message = $body;
					Mail::to($request->input('user_id'))->send(new SendEmail($mail));
					
					$log = new EmailLog();
					$log->receiver_email = $request->input('user_id');
					$log->subject = $subject;
					$log->message = $body;
					$log->sender_id = Auth::user()->id;
					$log->save();
			   }else{
				   return redirect('email/compose')->with('error', _lang('Invalid mobile number Or Illegal Operation !'))->withInput();
			   }
			   
			}
		}
		
		if($request->input('student_id') != ""){
			if($request->input('student_id') == "all"){
			   foreach( $request->input('users') as $receiver_email ){
				  if( Auth::user()->email == $receiver_email || $receiver_email == ""){
					  continue;
				  }
					//Send Email
					$mail  = new \stdClass();
					$mail->subject = $subject;
					$mail->message = $body;
					Mail::to($receiver_email)->send(new SendEmail($mail));
				  
					$log = new EmailLog();
					$log->receiver_email = $receiver_email;
					$log->subject = $subject;
					$log->message = $body;
					$log->sender_id = Auth::user()->id;
					$log->save();
			   }
			}else{
			   if( Auth::user()->email != $request->input('student_id') || $request->input('student_id') != "" ){	
					
					//Send Email
					$mail  = new \stdClass();
					$mail->subject = $subject;
					$mail->message = $body;
					Mail::to($request->input('student_id'))->send(new SendEmail($mail));
				   
					$log = new EmailLog();
					$log->receiver_email = $request->input('student_id');
					$log->subject = $subject;
					$log->message = $body;
					$log->sender_id = Auth::user()->id;
					$log->save();
			   }else{
				   return redirect('message/compose')->with('error', _lang('Invalid mobile number Or Illegal Operation !'))->withInput();
			   }
			}
		}
		
		return redirect()->back()->with('success', _lang('Email Send Sucessfully.'));
	
    }
}