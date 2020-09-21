<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;
use App\UserNotice;
use Validator;
use Illuminate\Validation\Rule;

class NoticeController extends Controller
{
		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::all()->sortByDesc("id");
        return view('backend.notice.list',compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.notice.create');
		}else{
           return view('backend.notice.modal.create');
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
			'heading' => 'required',
			'content' => 'required',
			'user_type' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('notices/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			
	    
		
        $notice= new Notice();
	    $notice->heading = $request->input('heading');
		$notice->content = $request->input('content');
        $notice->save();
		
		foreach($request->input('user_type') as $user_type){
			$userNotice = new UserNotice();
			$userNotice->notice_id = $notice->id;
			$userNotice->user_type = $user_type;
			$userNotice->save();
		}
        
		if(! $request->ajax()){
           return redirect('notices/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$notice]);
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
        $notice = Notice::find($id);
		if(! $request->ajax()){
		    return view('backend.notice.view',compact('notice','id'));
		}else{
			return view('backend.notice.modal.view',compact('notice','id'));
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
        $notice = Notice::find($id);
		if(! $request->ajax()){
		   return view('backend.notice.edit',compact('notice','id'));
		}else{
           return view('backend.notice.modal.edit',compact('notice','id'));
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
			'heading' => 'required',
			'content' => 'required',
			'user_type' => 'required'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('notices.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $notice = Notice::find($id);
		$notice->heading = $request->input('heading');
		$notice->content = $request->input('content');	
        $notice->save();
		
		$userNotice = UserNotice::where("notice_id",$id);
		$userNotice->delete();
		
		foreach($request->input('user_type') as $user_type){
			$userNotice = new UserNotice();
			$userNotice->notice_id = $notice->id;
			$userNotice->user_type = $user_type;
			$userNotice->save();
		}
		
		if(! $request->ajax()){
           return redirect('notices')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$notice]);
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
        $notice = Notice::find($id);
        $notice->delete();
		
		$userNotice = UserNotice::where("notice_id",$id);
		$userNotice->delete();
		
        return redirect('notices')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
