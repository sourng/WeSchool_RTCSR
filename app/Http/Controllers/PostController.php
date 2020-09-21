<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostContent;
use Validator;
use Auth;

class PostController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type="post")
    {
		$langs=app()->getLocale();

        $posts = Post::where("post_type",$type)
		         ->orderBy("id",'desc')->get();
        return view('backend.cms.post.list',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$langs=app()->getLocale();

		if( ! $request->ajax()){
		   return view('backend.cms.post.create');
		}else{
           return view('backend.cms.post.modal.create');
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
			'post_title' => 'required',
			'featured_image' => 'nullable|image',
		]);

		$langs=app()->getLocale();
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('posts/create')
							->withErrors($validator)
							->withInput();
			}			
		}
			

        $post = new Post();
		$slug = $request->input('slug') =="" ? strtolower(preg_replace('/[[:space:]]+/', '_', $request->post_title[0])) : $request->input('slug');
	    $post->slug = str_replace("?","",$slug);
		$post->post_type = $request->input('post_type');
		$post->post_status = $request->input('post_status');
		if ($request->hasFile('featured_image')) {
			$image = $request->file('featured_image');
			$name = 'post_image_'.time().".".$image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/media');
			$image->move($destinationPath, $name);
			$post->featured_image = $name;
		}
		$post->category_id = $request->input('post_category');
		$post->author_id = Auth::User()->id;
        $post->save();
		
		$index = 0;
		foreach($request->post_title as $title){
			$postContent = new PostContent();
			$postContent->post_id = $post->id;
			$postContent->post_title = $title =="" ? $request->post_title[0] : $title;
			$postContent->post_content	= $request->post_content[$index] !="" ? $request->post_content[0] : $request->post_content[$index];
			if(isset($request->meta_data[$index])){
				$postContent->language	= serialize($request->language[$index]);
			}
			// $postContent->language	= $request->language[$index];
			$postContent->language	= $langs;
			$postContent->save();
			$index++;
		}
		
        
		if(! $request->ajax()){
           return redirect()->back()->with('success', _lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$post]);
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
        $post = Post::find($id);
		if(! $request->ajax()){
		    return view('backend.cms.post.view',compact('post','id'));
		}else{
			return view('backend.cms.post.modal.view',compact('post','id'));
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
        $post = Post::find($id);
		if(! $request->ajax()){
		   return view('backend.cms.post.edit',compact('post','id'));
		}else{
           return view('backend.cms.post.modal.edit',compact('post','id'));
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
			'post_title' => 'required',
			'featured_image' => 'nullable|image',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('posts.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	

        $post = Post::find($id);
		$slug = $request->input('slug') =="" ? strtolower(preg_replace('/[[:space:]]+/', '_', $request->post_title[0])) : $request->input('slug');
	    $post->slug = str_replace("?","",$slug);
		$post->post_type = $request->input('post_type');
		$post->post_status = $request->input('post_status');
		if ($request->hasFile('featured_image')) {
			$image = $request->file('featured_image');
			$name = 'post_image_'.time().".".$image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/media');
			$image->move($destinationPath, $name);
			$post->featured_image = $name;
		}
		$post->category_id = $request->input('post_category');
		$post->author_id = Auth::User()->id;
        $post->save();
		
		$index = 0;
		foreach($request->post_title as $title){
			if($request->post_content_id[$index] != ""){
				$postContent = PostContent::find($request->post_content_id[$index]);
			}else{
				$postContent = new PostContent();
			}
			$postContent->post_id = $post->id;
			$postContent->post_title = $title =="" ? $request->post_title[0] : $title;
			$postContent->post_content	= $request->post_content[$index]=="" ? $request->post_content[0] : $request->post_content[$index];
			$postContent->language	= $request->language[$index];
			$postContent->save();
			$index++;
		}
		
		if(! $request->ajax()){
           return redirect('posts/type/'.$request->post_type)->with('success', _lang('Updated sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated sucessfully'),'data'=>$post]);
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
        $post = Post::find($id);
        $post->delete();
		
		$postContent = PostContent::where("post_id",$id);
		$postContent->delete();
		
        return redirect('posts/type/'.$post->post_type)->with('success',_lang('Information has been deleted sucessfully'));
    }
	
}
