<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NavigationItem;
use Validator;
use Illuminate\Validation\Rule;

class NavigationItemController extends Controller
{
		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($navigation_id = "")
    {
        $navigationitems = NavigationItem::where("navigation_id",$navigation_id)
		                   ->orderBy("menu_order","asc")->get();
		$navigation_id = $navigation_id;
        return view('backend.cms.site_navigation_item.list',compact('navigationitems','navigation_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$navigation_id)
    {
		$navigation_id = $navigation_id;
		$pages = \App\Page::where("page_status","publish")->get();
		if( ! $request->ajax()){
		   return view('backend.cms.site_navigation_item.create',compact('navigation_id','pages'));
		}else{
           return view('backend.cms.site_navigation_item.modal.create',compact('navigation_id','pages'));
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
			'navigation_id' => 'required',
			'menu_label' => 'required|max:191',
			'link' => 'required_without:page_id',
			'page_id' => 'required_without:link',
		]);
		
		$attributeNames = array('page_id' => 'Page');
		$validator->setAttributeNames($attributeNames);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->back()
							->withErrors($validator)
							->withInput();
			}			
		}
			
	    
        $navigationitem= new NavigationItem();
	    $navigationitem->navigation_id = $request->input('navigation_id');
		$navigationitem->menu_label = $request->input('menu_label');
		$navigationitem->link = $request->input('link');
		$navigationitem->page_id = $request->input('page_id');
		$navigationitem->parent_id = $request->input('parent_id');
	    $navigationitem->css_class = $request->input('css_class');
	    $navigationitem->css_id = $request->input('css_id');
	
        $navigationitem->save();
        
		if(! $request->ajax()){
           return redirect('site_navigation_items/navigation/'.$navigationitem->navigation_id)->with('success', _lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$navigationitem]);
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
        $navigationitem = NavigationItem::find($id);
		$pages = \App\Page::where("page_status","publish")->get();
		if(! $request->ajax()){
		   return view('backend.cms.site_navigation_item.edit',compact('navigationitem','id','pages'));
		}else{
           return view('backend.cms.site_navigation_item.modal.edit',compact('navigationitem','id','pages'));
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
			'navigation_id' => 'required',
			'menu_label' => 'required|max:191',
			'link' => 'required_without:page_id',
			'page_id' => 'required_without:link',
		]);
		
		$attributeNames = array('page_id' => 'Page');
		$validator->setAttributeNames($attributeNames);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->back()
							->withErrors($validator)
							->withInput();
			}			
		}
	

        $navigationitem = NavigationItem::find($id);
		$navigationitem->navigation_id = $request->input('navigation_id');
		$navigationitem->menu_label = $request->input('menu_label');
		$navigationitem->link = $request->input('link');
		$navigationitem->page_id = $request->input('page_id');
		$navigationitem->parent_id = $request->input('parent_id');
	    $navigationitem->css_class = $request->input('css_class');
	    $navigationitem->css_id = $request->input('css_id');
	
        $navigationitem->save();
		
		if(! $request->ajax()){
           return redirect('site_navigation_items/navigation/'.$navigationitem->navigation_id)
				  ->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$navigationitem]);
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
        $navigationitem = NavigationItem::find($id);
        $navigationitem->delete();
        return redirect('site_navigation_items/navigation/'.$navigationitem->navigation_id)->with('success',_lang('Deleted Sucessfully'));
    }
}
