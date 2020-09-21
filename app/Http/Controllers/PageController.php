<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\PageContent;
use Validator;
use Auth;

class PageController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$pages = Page::all()->sortByDesc("id");
        return view('backend.cms.page.list',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.cms.page.create');
		}else{
           return view('backend.cms.page.modal.create');
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
			'page_title' => 'required',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('pages/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			

        $page = new Page();
		$slug = $request->input('slug') =="" ? strtolower(preg_replace('/[[:space:]]+/', '_', $request->page_title[0])) : $request->input('slug');
	    $page->slug = str_replace("?","",$slug); 
		$page->page_status = $request->input('page_status');
		if ($request->hasFile('featured_image')) {
			$image = $request->file('featured_image');
			$name = 'page_image_'.time().".".$image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/media');
			$image->move($destinationPath, $name);
			$page->featured_image = $name;
		}
		$page->page_template = $request->input('page_template');
		$page->author_id = Auth::User()->id;
        $page->save();
		
		$index = 0;
		foreach($request->page_title as $title){
			$pageContent = new PageContent();
			$pageContent->page_id = $page->id;
			$pageContent->page_title = $title =="" ? $request->page_title[0] : $title;
			$pageContent->page_content	= $request->page_content[$index] !="" ? $request->page_content[0] : $request->page_content[$index];
			$pageContent->seo_meta_keywords	= $request->seo_meta_keywords[$index];
			$pageContent->seo_meta_description	= $request->seo_meta_description[$index];
			$pageContent->language	= $request->language[$index];
			$pageContent->save();
			$index++;
		}
		
        
		if(! $request->ajax()){
           return redirect('pages/create')->with('success', _lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$page]);
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
        $page = Page::find($id);
		if(! $request->ajax()){
		    return view('backend.cms.page.view',compact('page','id'));
		}else{
			return view('backend.cms.page.modal.view',compact('page','id'));
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
        $page = Page::find($id);
		if(! $request->ajax()){
		   return view('backend.cms.page.edit',compact('page','id'));
		}else{
           return view('backend.cms.page.modal.edit',compact('page','id'));
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
			'page_title' => 'required',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('pages.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	

        $page = page::find($id);
		$slug = $request->input('slug') =="" ? strtolower(preg_replace('/[[:space:]]+/', '_', $request->page_title[0])) : $request->input('slug');
	    $page->slug = str_replace("?","",$slug);
		$page->page_status = $request->input('page_status');
		if ($request->hasFile('featured_image')) {
			$image = $request->file('featured_image');
			$name = 'page_image_'.time().".".$image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/media');
			$image->move($destinationPath, $name);
			$page->featured_image = $name;
		}
		$page->page_template = $request->input('page_template');
		$page->author_id = Auth::User()->id;
        $page->save();
		
		$index = 0;
		foreach($request->page_title as $title){
			if($request->page_content_id[$index] != ""){
				$pageContent = PageContent::find($request->page_content_id[$index]);
			}else{
				$pageContent = new PageContent();
			}
			$pageContent->page_id = $page->id;
			$pageContent->page_title = $title =="" ? $request->page_title[0] : $title;
			$pageContent->page_content	= $request->page_content[$index] !="" ? $request->page_content[0] : $request->page_content[$index];
			$pageContent->seo_meta_keywords	= $request->seo_meta_keywords[$index];
			$pageContent->seo_meta_description	= $request->seo_meta_description[$index];
			$pageContent->language	= $request->language[$index];
			$pageContent->save();
			$index++;
		}
		
		if(! $request->ajax()){
           return redirect('pages')->with('success', _lang('Updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated sucessfully'),'data'=>$page]);
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
        $page = Page::find($id);
        $page->delete();
		
		$pageContent = PageContent::where("page_id",$id);
		$pageContent->delete();
		
        return redirect('pages')->with('success',_lang('Information has been deleted sucessfully'));
    }
	
}
