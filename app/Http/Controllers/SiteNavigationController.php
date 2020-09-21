<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteNavigation;
use Validator;
use Illuminate\Validation\Rule;

class SiteNavigationController extends Controller
{
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sitenavigations = SiteNavigation::all()->sortByDesc("id");
        // dd($sitenavigations);
        return view('backend.cms.site_navigation.list',compact('sitenavigations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.cms.site_navigation.create');
		}else{
           return view('backend.cms.site_navigation.modal.create');
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
			'menu_name' => 'required|max:191'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('site_navigations/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			
	    
		
        $sitenavigation= new SiteNavigation();
	    $sitenavigation->menu_name = $request->input('menu_name');
	
        $sitenavigation->save();
        
		if(! $request->ajax()){
           return redirect('site_navigations/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$sitenavigation]);
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
        $sitenavigation = SiteNavigation::find($id);
		if(! $request->ajax()){
		   return view('backend.cms.site_navigation.edit',compact('sitenavigation','id'));
		}else{
           return view('backend.cms.site_navigation.modal.edit',compact('sitenavigation','id'));
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
			'menu_name' => 'required|max:191'
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('site_navigations.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $sitenavigation = SiteNavigation::find($id);
		$sitenavigation->menu_name = $request->input('menu_name');
	
        $sitenavigation->save();
		
		if(! $request->ajax()){
           return redirect('site_navigations')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$sitenavigation]);
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
        $sitenavigation = SiteNavigation::find($id);
        $sitenavigation->delete();
        return redirect('site_navigations')->with('success',_lang('Information has been deleted sucessfully'));
    }
}
