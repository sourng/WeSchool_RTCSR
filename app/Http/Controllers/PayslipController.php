<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Payslip;
use App\Employee;
use App\StaffAttendance;
use App\Expense;
use App\DefaultAllowance;
use App\DefaultDeduction;
use App\Allowance;
use App\Deduction;
use App\Transaction;
use Carbon\Carbon;
use Validator;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payslips = array();
        $month_year = date('m/Y');
        if($request->isMethod('post')){
            $month_year = (explode('/', $request->month_year));
            $payslips = Payslip::select('*')
                                    ->where('month', $month_year[0])
                                    ->where('year', $month_year[1])
                                    ->orderBy('id', 'DESC')
                                    ->get();
            $month_year = $request->month_year;
        }
        
        return view('backend.payslips.index', compact('payslips', 'month_year'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_payslips()
    {
        $payslips = Payslip::where('user_id',\Auth::user()->id)->orderBy('id', 'DESC')->get();
        
        return view('backend.payslips.my_payslips', compact('payslips'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $payslips = array();
        return view('backend.payslips.create', compact('payslips'));
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

            'month_year' => 'required',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }			
        }
        $payslips = array();
        $payslip_ids = array();
        $month_year = (explode('/', $request->month_year));
        $employees = \DB::select("SELECT employees.user_id AS user_id, employees.current_salary FROM employees LEFT OUTER JOIN payslips ON employees.user_id = payslips.user_id AND payslips.month = $month_year[0] AND payslips.year = $month_year[1] INNER JOIN users ON users.id = employees.id WHERE payslips.user_id is null AND users.status = 1");
        foreach ($employees as $employee) {
            $expense_claim = Expense::where('expense_by', $employee->user_id)
                            ->whereMonth('date', $month_year[0])
                            ->whereYear('date', $month_year[1])
                            ->where('status', 1)
                            ->sum('amount');
            $fine_amount = (get_option('absent_fine') != '') ? get_option('absent_fine') : 0;
            $absent_fine = StaffAttendance::select([
                                            \DB::raw("(COUNT(id) * $fine_amount) AS absent_fine"),
                                        ])
                                        ->where('user_id', $employee->user_id)
                                        ->whereMonth('date', $month_year[0])
                                        ->whereYear('date', $month_year[1])
                                        ->where('staff_attendances.attendance', 2)
                                        ->first()->absent_fine;

            $default_allowances = DefaultAllowance::where('user_id', $employee->user_id)->get();
            $default_deductions = DefaultDeduction::where('user_id', $employee->user_id)->get();
            $total_allowance = $employee->current_salary + $expense_claim + $default_allowances->sum('amount');
            $total_deduction = $absent_fine + $default_deductions->sum('amount');

            $payslip = new Payslip();
            $payslip->user_id = $employee->user_id;
            $payslip->month = $month_year[0];
            $payslip->year = $month_year[1];
            $payslip->current_salary = $employee->current_salary;
            $payslip->expense_claim = number_format($expense_claim, 2);
            $payslip->absent_fine = number_format($absent_fine, 2);
            $payslip->net_salary = number_format($total_allowance - $total_deduction, 2);
            $payslip->status = 0;
            $payslip->save();

            foreach ($default_allowances as $default_allowance) {
                $allowance = new Allowance();
                $allowance->payslip_id = $payslip->id;
                $allowance->title = $default_allowance->title;
                $allowance->amount = $default_allowance->amount;
                $allowance->save();
            }
            foreach ($default_deductions as $default_deduction) {
                $deduction = new Deduction();
                $deduction->payslip_id = $payslip->id;
                $deduction->title = $default_deduction->title;
                $deduction->amount = $default_deduction->amount;
                $deduction->save();
            }
        }
        $payslips = Payslip::select('payslips.*', 'users.name AS employee_name', 'employees.employee_id')
                                ->join('users', 'users.id', '=', 'payslips.user_id')
                                ->join('employees', 'employees.user_id', '=', 'payslips.user_id')
                                ->where('month', $month_year[0])
                                ->where('year', $month_year[1])
                                ->orderBy('payslips.id', 'DESC')
                                ->get();
        $success =  _lang('Payslips has been created sucessfully');
        return view('backend.payslips.create', compact('payslips', 'success'));

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $payslip = Payslip::select([
                                "payslips.*",
                                "department",
                                "designation",
                                "users.name AS name",
                                "employees.employee_id AS employee_id"
                            ])
                            ->join('employees', 'employees.user_id', '=', 'payslips.user_id')
                            ->join('users', 'users.id', '=', 'employees.user_id')
                            ->join('departments', 'departments.id', '=', 'department_id')
                            ->join('designations', 'designations.id', '=', 'designation_id')
                            ->where('payslips.id', '=', $id)
                            ->first();
        $allowances = Allowance::where('payslip_id', $payslip->id)->get();
        $deductions = Deduction::where('payslip_id', $payslip->id)->get();
        return view('backend.payslips.show', compact('payslip', 'allowances', 'deductions'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request,$id)
    {
        $payslip = Payslip::find($id);
        $payslip->month_year = $payslip->month . '/' . $payslip->year;
        $allowances = Allowance::where('payslip_id', $payslip->id)->get();
        $deductions = Deduction::where('payslip_id', $payslip->id)->get();
        return view('backend.payslips.edit', compact('payslip', 'month_year', 'allowances', 'deductions'));  
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
        $payslip = Payslip::find($id);

        $total_allowance = $payslip->current_salary + $payslip->expense_claim + (!empty($request->allowance_amount) ? array_sum($request->allowance_amount) : 0);
        $total_deduction = $payslip->absent_fine + (!empty($request->deduction_amount) ? array_sum($request->deduction_amount) : 0);

        $payslip->net_salary = number_format($total_allowance - $total_deduction, 2);
        $payslip->save();
        
        if(! empty($request->allowance_amount)){
            for ($i=0; $i < count($request->allowance_amount); $i++) { 
                if($request->allowance_title[$i] != '' && $request->allowance_amount[$i] != ''){
                    if($request->allowance_id[$i] != ''){
                        $allowance = Allowance::find($request->allowance_id[$i]);
                        $allowance->title = $request->allowance_title[$i];
                        $allowance->amount = $request->allowance_amount[$i];
                        $allowance->save();
                    }else{
                        $allowance = new Allowance();
                        $allowance->payslip_id = $payslip->id;
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
                        $deduction = Deduction::find($request->deduction_id[$i]);
                        $deduction->title = $request->deduction_title[$i];
                        $deduction->amount = $request->deduction_amount[$i];
                        $deduction->save();
                    }else{
                        $deduction = new Deduction();
                        $deduction->payslip_id = $payslip->id;
                        $deduction->title = $request->deduction_title[$i];
                        $deduction->amount = $request->deduction_amount[$i];
                        $deduction->save();
                    }
                }
            }
        }

        if(! $request->ajax()){
            return redirect('payslips')->with('success', _lang('Information has been updated sucessfully'));
        }else{
            return response()->json(['result' => 'success', 'redirect' => url('payslips'), 'message' => _lang('Information has been updated sucessfully')]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function make_payment(Request $request)
    {
        $month_year = Carbon::now()->format('m/Y');
        $payslips = array();
        if($request->isMethod('post')){
            $this->validate($request, [
                'month_year' => 'required',
            ]);
            $month_year = (explode('/', $request->month_year));
            $payslips = Payslip::select('payslips.*', 'users.name AS employee_name', 'employees.employee_id')
                                ->join('users', 'users.id', '=', 'payslips.user_id')
                                ->join('employees', 'employees.user_id', '=', 'payslips.user_id')
                                ->where('month', $month_year[0])
                                ->where('year', $month_year[1])
                                ->where('payslips.status', 0)
                                ->orderBy('payslips.id', 'DESC')
                                ->get();
            $month_year = $request->month_year;
        }

        return view('backend.payslips.make_payment', compact('month_year', 'payslips'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function selection(Request $request)
    {
        if($request->id != null){
            $ids = $request->id;
            $amount = Payslip::whereIn('id', $ids)->orderBy('id', 'DESC')->sum('net_salary');
            if(! $request->ajax()){
                return view('backend.payslips.selection', compact('amount', 'ids'));
            }else{
                return view('backend.payslips.modal.selection', compact('amount', 'ids'));
            }
        }else{
            if(! $request->ajax()){
                return back()->with('error', _lang('At least check one payslip.'));
            }else{
                return 0;
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required',
            'amount' => 'required|numeric',
            'chart_id' => 'required',
            'trans_type' => 'required',
            'payment_method_id' => 'required',
            'dr_cr' => 'required',
            'id.*' => 'required',
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }
        $ids = $request->id;
        $payslips = Payslip::whereIn('id', $ids)->orderBy('id', 'DESC')->get();
        foreach ($payslips as $payslip) {
            $payslip->status = 1;
            $payslip->save();
        }
        $amount = Payslip::whereIn('id', $ids)->orderBy('id', 'DESC')->sum('net_salary');
        $transaction= new Transaction();
        $transaction->trans_date = Carbon::now()->format('Y-m-d');
        $transaction->account_id = $request->account_id;
        $transaction->amount = $amount;
        $transaction->chart_id = $request->chart_id;
        $transaction->trans_type = $request->trans_type;
        $transaction->dr_cr = $request->dr_cr;
        $transaction->payment_method_id = $request->payment_method_id;
        $transaction->create_user_id = \Auth::user()->id;
        $transaction->reference = $request->reference;
        $transaction->note = $request->note;
        $transaction->save();

        if(! $request->ajax()){
            return redirect('payslips/make_payment')->with('success', _lang('Payment has been sucessfully done.'));
        }else{
            return response()->json(['result' => 'success', 'redirect' => url('payslips/make_payment'), 'message' => _lang('Payment has been sucessfully done.')]);
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
            $allowance = Allowance::find($id);
            $allowance->delete();
        }elseif($type == 'deduction'){
            $deduction = Deduction::find($id);
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
        $payslip = Payslip::where('id', $id)->where('status', 0)->first();
        $payslip->delete();
        return redirect('payslips')->with('success', _lang('Information has been deleted'));
    }
}
