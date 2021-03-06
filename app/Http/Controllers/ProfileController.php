<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use App\User;
use App\Teacher;
use App\TeacherAddress;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    
    public function my_profile()
    {
        $profile = User::find(Auth::User()->id);
		
		$teachers = Teacher::select('*','teachers.id AS id')
        ->join('users','users.id','=','teachers.user_id')
		->where('teachers.user_id',Auth::User()->id)->get();
		
		$address=TeacherAddress::where('teacher_id',$teachers[0]->id)->get();
		
		//dd($address);
		
        return view('backend.profile.profile-view',compact('profile','teachers','address'));
    }


    public function edit()
    {
        $profile = User::find(Auth::User()->id);
       
		
		$teachers = Teacher::select('*','teachers.id AS id')
        ->join('users','users.id','=','teachers.user_id')
		->where('teachers.user_id',Auth::User()->id)->get();
        //->orderBy('teachers.id', 'DESC')->get();
		
         //dd($teachers[0]->name);

        return view('backend.profile.profile-edit',compact('profile','teachers'));
    }


    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|string|max:20',
            'email' => [
                'required',
                Rule::unique('users')->ignore(Auth::User()->id),
            ],
            'image' => 'nullable|image|max:5120',
        ]);

        $profile = User::find(Auth::User()->id);
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
		$profile->facebook = $request->facebook=="" ? "#" : $request->facebook;
	    $profile->twitter = $request->twitter=="" ? "#" : $request->twitter;
	    $profile->linkedin = $request->linkedin=="" ? "#" : $request->linkedin;
	    $profile->google_plus = $request->google_plus=="" ? "#" : $request->google_plus;
        $profile->save();

        return redirect('profile/my_profile')->with('success', _lang('Information has been updated'));
    }

    /**
     * Show the form for change_password the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_password()
    {
        return view('backend.profile.change-password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find(Auth::User()->id);
        if(Hash::check($request->oldpassword, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
        }else{
            return back()->with('error', _lang('Old Password not match'));
        }
        return back()->with('success', _lang('Password has been changed'));
    }

}
