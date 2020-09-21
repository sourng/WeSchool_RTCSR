<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Employee;
use App\User;
use App\DefaultAllowance;
use App\DefaultDeduction;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderBy('id', 'DESC')->get();
        return view('backend.employees.index', compact('employees'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function select(Request $request)
    {
        if(! $request->isMethod('post')){
            if( ! $request->ajax()){
                return view('backend.employees.select');
            }else{
                return view('backend.employees.modal.select');
            }
        }else{
            if(! Employee::where('user_id', $request->user_id)->exists()){
                if(! $request->ajax()){
                    return redirect('employees/create/' . $request->user_id);
                }else{
                    return response()->json(['result'=>'success', 'redirect'=> url('employees/create/' . $request->user_id)]);
                }
            }else{
                if($request->ajax()){ 
                    return response()->json(['result'=>'error', 'message'=> [_lang('The user_id has already been taken.')]]);
                }else{
                    return back()->with('error', _lang('The user_id has already been taken.'));
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $user_id)
    {
        $user = User::find($user_id);
        return view('backend.employees.create', compact('user'));
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

            'user_id' => 'required|unique:employees',
            'father_name' => 'nullable|string|max:191',
            'mother_name' => 'nullable|string|max:191',
            'dob' => 'nullable|date',
            'street' => 'required|string|max:191',
            'state' => 'required|string|max:80',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:80',
            'employee_id' => 'required|unique:employees',
            'department_id' => 'required|numeric',
            'designation_id' => 'required|numeric',
            'joining_date' => 'required|date',
            'exit_date' => 'nullable|date',
            'joining_salary' => 'required|numeric',
            'current_salary' => 'required|numeric',
            'account_holder_name' => 'nullable|string|max:191',
            'account_number' => 'nullable|string|max:80',
            'bank_name' => 'nullable|string|max:191',
            'bank_identifier_code' => 'nullable|string|max:100',
            'branch_location' => 'nullable|string|max:100',
            'resume' => 'nullable|max:5120|mimes:doc,docx,pdf',
            'joining_letter' => 'nullable|max:5120|mimes:doc,docx,pdf',
            'id_card' => 'nullable|max:5120|mimes:doc,docx,pdf',

        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error', 'message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        $employee = new Employee();
        
        $employee->user_id = $request->user_id;
        $employee->father_name = $request->father_name;
        $employee->mother_name = $request->mother_name;
        $employee->dob = $request->dob;
        $employee->street = $request->street;
        $employee->state = $request->state;
        $employee->zip_code = $request->zip_code;
        $employee->country = $request->country;
        $employee->employee_id = $request->employee_id;
        $employee->department_id = $request->department_id;
        $employee->designation_id = $request->designation_id;
        $employee->joining_date = $request->joining_date;
        $employee->exit_date = $request->exit_date;
        $employee->joining_salary = $request->joining_salary;
        $employee->current_salary = $request->current_salary;
        $employee->account_holder_name = $request->account_holder_name;
        $employee->account_number = $request->account_number;
        $employee->bank_name = $request->bank_name;
        $employee->bank_identifier_code = $request->bank_identifier_code;
        $employee->branch_location = $request->branch_location;
        
        if($request->hasFile('resume')){
            $file = $request->file('resume');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/'), $file_name);
            $employee->resume = 'files/' . $file_name;
        }
        if($request->hasFile('joining_letter')){
            $file = $request->file('joining_letter');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/'), $file_name);
            $employee->joining_letter = 'files/' . $file_name;
        }
        if($request->hasFile('id_card')){
            $file = $request->file('id_card');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/'), $file_name);
            $employee->id_card = 'files/' . $file_name;
        }
        
        $employee->save();

        if(! empty($request->allowance_amount)){
            for ($i=0; $i < count($request->allowance_amount); $i++) { 
                if($request->allowance_title[$i] != '' && $request->allowance_amount[$i] != ''){
                    $allowance = new DefaultAllowance();
                    $allowance->user_id = $employee->user_id;
                    $allowance->title = $request->allowance_title[$i];
                    $allowance->amount = $request->allowance_amount[$i];
                    $allowance->save();
                }
            }
        }
        if(! empty($request->deduction_amount)){
            for ($i=0; $i < count($request->deduction_amount); $i++) { 
                if($request->deduction_title[$i] != '' && $request->deduction_amount[$i] != ''){
                    $deduction = new DefaultDeduction();
                    $deduction->user_id = $employee->user_id;
                    $deduction->title = $request->deduction_title[$i];
                    $deduction->amount = $request->deduction_amount[$i];
                    $deduction->save();
                }
            }
        }
        
        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been added sucessfully'));
        }else{
            return response()->json(['result'=>'success', 'redirect'=> url('employees'), 'message'=> _lang('Information has been added sucessfully')]);
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
        $employee = Employee::find($id);
        if(! $request->ajax()){
            return view('backend.employees.show', compact('employee'));
        }else{
            return view('backend.employees.modal.show', compact('employee'));
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function my_profile()
    {
        $employee = Employee::find(get_employee_id());
        return view('backend.employees.my_profile', compact('employee')); 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $employee = Employee::find($id);
        $default_allowances = DefaultAllowance::where('user_id', $employee->user_id)
                                                ->orderBy('id', 'ASC')
                                                ->get();
        $default_deductions = DefaultDeduction::where('user_id', $employee->user_id)
                                                ->orderBy('id', 'ASC')
                                                ->get();
        return view('backend.employees.edit', compact('employee', 'default_allowances', 'default_deductions'));  
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
        $employee = Employee::find($id);
        $validator = Validator::make($request->all(), [

            'father_name' => 'nullable|string|max:191',
            'mother_name' => 'nullable|string|max:191',
            'dob' => 'nullable|date',
            'street' => 'required|string|max:191',
            'state' => 'required|string|max:80',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:80',
            'department_id' => 'required|numeric',
            'designation_id' => 'required|numeric',
            'joining_date' => 'required|date',
            'exit_date' => 'nullable|date',
            'joining_salary' => 'required|numeric',
            'current_salary' => 'required|numeric',
            'account_holder_name' => 'nullable|string|max:191',
            'account_number' => 'nullable|string|max:80',
            'bank_name' => 'nullable|string|max:191',
            'bank_identifier_code' => 'nullable|string|max:100',
            'branch_location' => 'nullable|string|max:100',
            'profile' => 'nullable|image|max:5120',
            'resume' => 'nullable|max:5120|mimes:doc,docx,pdf',
            'joining_letter' => 'nullable|max:5120|mimes:doc,docx,pdf',
            'id_card' => 'nullable|max:5120|mimes:doc,docx,pdf',

        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error', 'message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }
        
        
        $employee->father_name = $request->father_name;
        $employee->mother_name = $request->mother_name;
        $employee->dob = $request->dob;
        $employee->street = $request->street;
        $employee->state = $request->state;
        $employee->zip_code = $request->zip_code;
        $employee->country = $request->country;
        $employee->department_id = $request->department_id;
        $employee->designation_id = $request->designation_id;
        $employee->joining_date = $request->joining_date;
        $employee->exit_date = $request->exit_date;
        $employee->joining_salary = $request->joining_salary;
        $employee->current_salary = $request->current_salary;
        $employee->account_holder_name = $request->account_holder_name;
        $employee->account_number = $request->account_number;
        $employee->bank_name = $request->bank_name;
        $employee->bank_identifier_code = $request->bank_identifier_code;
        $employee->branch_location = $request->branch_location;
        
        if($request->hasFile('resume')){
            $file = $request->file('resume');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/'), $file_name);
            $employee->resume = 'files/' . $file_name;
        }
        if($request->hasFile('joining_letter')){
            $file = $request->file('joining_letter');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/'), $file_name);
            $employee->joining_letter = 'files/' . $file_name;
        }
        if($request->hasFile('id_card')){
            $file = $request->file('id_card');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/'), $file_name);
            $employee->id_card = 'files/' . $file_name;
        }

        $employee->save();

        if(! empty($request->allowance_amount)){
            for ($i=0; $i < count($request->allowance_amount); $i++) { 
                if($request->allowance_title[$i] != '' && $request->allowance_amount[$i] != ''){
                    if($request->allowance_id[$i] != ''){
                        $allowance = DefaultAllowance::find($request->allowance_id[$i]);
                        $allowance->title = $request->allowance_title[$i];
                        $allowance->amount = $request->allowance_amount[$i];
                        $allowance->save();
                    }else{
                        $allowance = new DefaultAllowance();
                        $allowance->user_id = $request->user_id;
                        $allowance->title = $request->allowance_title[$i];
                        $allowance->amount = $request->allowance_amount[$i];
                        $allowance->save();
                    }
                }
            }
        }
        if(! empty($request->deduction_amount)){
            for ($i=0; $i < count($request->deduction_amount); $i++) { 
                if($request->deduction_title[$i] != '' && $request->deduction_amount[$i] != ''){
                    if($request->deduction_id[$i] != ''){
                        $deduction = DefaultDeduction::find($request->deduction_id[$i]);
                        $deduction->title = $request->deduction_title[$i];
                        $deduction->amount = $request->deduction_amount[$i];
                        $deduction->save();
                    }else{
                        $deduction = new DefaultDeduction();
                        $deduction->user_id = $employee->user_id;
                        $deduction->title = $request->deduction_title[$i];
                        $deduction->amount = $request->deduction_amount[$i];
                        $deduction->save();
                    }
                }
            }
        }
        
        if(! $request->ajax()){
            return redirect('employees')->with('success', _lang('Information has been updated sucessfully'));
        }else{
            return response()->json(['result'=>'success', 'redirect'=> url('employees'), 'message'=>_lang('Information has been updated sucessfully')]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($type, $id)
    {
        if($type == 'allowance'){
            $allowance = DefaultAllowance::find($id);
            $allowance->delete();
        }elseif($type == 'deduction'){
            $deduction = DefaultDeduction::find($id);
            $deduction->delete();
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect('employees')->with('success', _lang('Information has been deleted'));
    }
}
