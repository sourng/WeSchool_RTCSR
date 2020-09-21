<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;
use Validator;
use Illuminate\Validation\Rule;

class PostCategoryController extends Controller
{	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postcategorys = PostCategory::where("type","post")
						->orderBy("id")->get();
        return view('backend.cms.post_category.list',compact('postcategorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.cms.post_category.create');
		}else{
           return view('backend.cms.post_category.modal.create');
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
			'category' => 'required|max:191',
			'trans_category.*' => 'required|max:191',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('post_categories/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			  
		
        $postcategory= new PostCategory();
	    $postcategory->category = $request->category;
	    //$postcategory->trans_category = serialize($request->trans_category);
		$postcategory->note = $request->input('note');
		$postcategory->type = $request->input('type');
		$postcategory->parent_id = $request->input('parent_id');
	
        $postcategory->save();
        
		if(! $request->ajax()){
           return redirect('post_categories/create')->with('success', _lang('Information has been added sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$postcategory]);
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
        $postcategory = PostCategory::find($id);
		if(! $request->ajax()){
		   return view('backend.cms.post_category.edit',compact('postcategory','id'));
		}else{
           return view('backend.cms.post_category.modal.edit',compact('postcategory','id'));
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
			'category' => 'required|max:191',
			'trans_category.*' => 'required|max:191',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('post_categories.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $postcategory = PostCategory::find($id);
		$postcategory->category = $request->category;
		//$postcategory->trans_category = serialize($request->trans_category);
		$postcategory->note = $request->input('note');
		$postcategory->type = $request->input('type');
		$postcategory->parent_id = $request->input('parent_id');
	
        $postcategory->save();
		
		if(! $request->ajax()){
           return redirect('post_categories')->with('success', _lang('Information has been updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Information has been updated sucessfully'),'data'=>$postcategory]);
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
        $postcategory = PostCategory::find($id);
        $postcategory->delete();
        return redirect('post_categories')->with('success',_lang('Information has been deleted sucessfully'));
    }
	
	public function get_category(){	
		$categories = []; 
		if( ! isset($_GET['term'])){
			$categories = PostCategory::select('id','category as text')
							->orderBy('id', 'DESC')
							->get();
		}else{
			$categories = PostCategory::select('id','category as text')
				   ->where('category','like', $_GET['term'].'%')
				   ->orderBy('id', 'DESC')
				   ->get();
		}		   
		echo json_encode($categories);		   	   
	}
}
