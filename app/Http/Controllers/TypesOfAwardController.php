<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\TypesOfAward;
use Validator;

class TypesOfAwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types_of_awards = TypesOfAward::orderBy('id', 'DESC')->get();
        return view('backend.types_of_awards.index', compact('types_of_awards'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
            return view('backend.types_of_awards.create');
        }else{
            return view('backend.types_of_awards.modal.create');
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
            
           	'title' => 'required|string|max:191',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }			
        }

        $types_of_award = new TypesOfAward();
        
        $types_of_award->title = $request->title;
        $types_of_award->status = 'Active';

        $types_of_award->save();

        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been added sucessfully'));
        }else{
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Information has been added sucessfully'),'data' => $types_of_award]);
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
        $types_of_award = TypesOfAward::find($id);
        if(! $request->ajax()){
            return view('backend.types_of_awards.show', compact('types_of_award'));
        }else{
            return view('backend.types_of_awards.modal.show', compact('types_of_award'));
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
        $types_of_award = TypesOfAward::find($id);
        if(! $request->ajax()){
            return view('backend.types_of_awards.edit', compact('types_of_award'));
        }else{
            return view('backend.types_of_awards.modal.edit', compact('types_of_award'));
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
            
           	'title' => 'required|string|max:191',
           	'status' => 'required|string|max:30',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }			
        }

        $types_of_award = TypesOfAward::find($id);
        
        $types_of_award->title = $request->title;
        $types_of_award->status = $request->status;

        $types_of_award->save();

        if(! $request->ajax()){
            return redirect('types_of_awards')->with('success', _lang('Information has been updated sucessfully'));
        }else{
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Information has been updated sucessfully'),'data' => $types_of_award]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $types_of_award = TypesOfAward::find($id);
        $types_of_award->delete();
        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been deleted'));
        }else{
            return response()->json(['result'=>'success','message'=>_lang('Information has been deleted sucessfully')]);
        }
    }
}
