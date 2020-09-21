<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\ParentModel;
use App\User;
use Image;
use Hash;

class ParentController extends Controller
{
    
    public function index()
    {
        $parents = ParentModel::select('users.*','students.first_name','students.last_name','parents.id AS id')
                                ->join('users','users.id','=','parents.user_id')
                                ->leftJoin('students','parents.id','=','students.parent_id')
								//->join('student_sessions','students.id','=','student_sessions.student_id')
								//->where('student_sessions.session_id',get_option('academic_year'))
                                ->orderBy('parents.id', 'DESC')
                                ->get();
        return view('backend.parents.parent-list',compact('parents'));
    }
	
	public function get_parents(){	
		$parents = []; 
		if( ! isset($_GET['term'])){
			$parents = ParentModel::select('id','parent_name as text')
					   ->orderBy('parents.id', 'DESC')
					   ->get();
		}else{
			$parents = ParentModel::select('id','parent_name as text')
				   ->where('parents.parent_name','like', '%'.$_GET['term'].'%')
				   ->orderBy('parents.id', 'DESC')
				   ->get();
		}		   
		echo json_encode($parents);		   
		//return response()->json($parents);		   
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.parents.parent-add');
		}else{
           return view('backend.parents.modal.create');
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
            'parent_name' => 'required|string|max:191',
            'f_name' => 'required|string|max:191',
            'm_name' => 'required',
            'f_profession' => 'nullable|string|max:191',
            'm_profession' => 'nullable|string|max:191',
            'phone' => 'nullable|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image|max:5120',
        ]);
		
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect('parents/create')
							->withErrors($validator)
							->withInput();
			}			
		}

        $ImageName='profile.png';
        if ($request->hasFile('image')){
             $image = $request->file('image');
             $ImageName = time().'.'.$image->getClientOriginalExtension();
             Image::make($image)->resize(200, 160)->save(base_path('public/uploads/images/parents/') . $ImageName);
        }

        $user = new User();
        $user->name = $request->parent_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 'Parent';
		$user->phone = $request->phone;
        $user->image = 'parents/'.$ImageName;
        $user->save();

        $parent = new ParentModel();
        $parent->user_id = $user->id;
		$parent->parent_name = $request->parent_name;
        $parent->f_name = $request->f_name;
        $parent->m_name = $request->m_name;
        $parent->f_profession = $request->f_profession;
        $parent->m_profession = $request->m_profession;
        $parent->phone = $request->phone;
        $parent->address = $request->address;
        $parent->save();

		if(! $request->ajax()){
           return redirect('parents')->with('success','Information has been added');
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Information has been added sucessfully'),'data'=>$parent]);
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
		$parent = ParentModel::join('users','users.id','=','parents.user_id')
					 ->leftJoin('students','parents.id','=','students.parent_id')
                     ->leftJoin('student_sessions','students.id','=','student_sessions.student_id')
                     ->leftJoin('classes','classes.id','=','student_sessions.class_id')
                     ->leftJoin('sections','sections.id','=','student_sessions.section_id')
					 //->where('student_sessions.session_id',get_option('academic_year'))
                     ->where('parents.id',$id)->first();
        if( ! $request->ajax()){
           return view('backend.parents.parent-view',compact('parent'));
        }else{
           return view('backend.parents.modal.parent-view',compact('parent'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parent = ParentModel::select('*','parents.id AS id')
                                ->join('users','users.id','=','parents.user_id')
                                ->where('parents.id',$id)
                                ->first();
        return view('backend.parents.parent-edit',compact('parent'));
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
        $parent = ParentModel::find($id);
        $this->validate($request, [
            'parent_name' => 'required|string|max:191',
            'f_name' => 'required|string|max:191',
            'm_name' => 'required|string|max:191',
            'f_profession' => 'nullable|string|max:191',
            'm_profession' => 'nullable|string|max:191',
            'phone' => 'nullable|max:191',
            'email' => [
                'required',
                Rule::unique('users')->ignore($parent->user_id),
            ],
            'password' => 'nullable|min:6|confirmed',
			'image' => 'nullable|image|max:5120',
        ]);

		$parent->parent_name = $request->parent_name;
        $parent->f_name = $request->f_name;
        $parent->m_name = $request->m_name;
        $parent->f_profession = $request->f_profession;
        $parent->m_profession = $request->m_profession;
        $parent->phone = $request->phone;
        $parent->address = $request->address;
        $parent->save();

        $user = User::find($parent->user_id);
        $user->name = $request->parent_name;
        $user->email = $request->email;
		$user->phone = $request->phone;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('image')){
             $image = $request->file('image');
             $ImageName = time().'.'.$image->getClientOriginalExtension();
             Image::make($image)->resize(200, 160)->save(base_path('public/uploads/images/parents/') . $ImageName);
             $user->image = 'parents/'.$ImageName;
        }
        $user->save();
        return redirect('parents')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parent = ParentModel::find($id);
        $parent->delete();
        $user = User::find($parent->user_id);
        $user->delete();
        
        return redirect('parents')->with('success', _lang('Information has been deleted'));
    }
}
