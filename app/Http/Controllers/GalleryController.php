<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostContent;
use Validator;
use Auth;

class GalleryController extends Controller
{
	
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.cms.gallery.create');
		}else{
           return view('backend.cms.gallery.modal.create');
		}
    }


    public function edit(Request $request,$id)
    {
        $post = Post::find($id);
		if(! $request->ajax()){
		   return view('backend.cms.gallery.edit',compact('post','id'));
		}else{
           return view('backend.cms.gallery.modal.edit',compact('post','id'));
		}  
        
    }

}
