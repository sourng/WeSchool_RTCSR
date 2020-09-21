<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Expense;
use App\Transaction;
use Carbon\Carbon;
use Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::orderBy('id', 'DESC')->get();
        return view('backend.expenses.index', compact('expenses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_expenses()
    {
        $expenses = Expense::where('expense_by', \Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('backend.expenses.my_expenses', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
            return view('backend.expenses.create');
        }else{
            return view('backend.expenses.modal.create');
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
        if(\Auth::user()->user_type != 'Admin'){
            $request->merge(['expense_by' => \Auth::user()->id]);
        }
        
        $validator = Validator::make($request->all(), [
            
            'name' => 'required|string|max:191',
            'purchase_from' => 'required|string|max:191',
            'date' => 'required|date',
            'amount' => 'required',
            'bill' => 'nullable|max:1240|mimes:doc,docx,pdf',
            'expense_by' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        $expense = new Expense();

        $expense->name = $request->name;
        $expense->purchase_from = $request->purchase_from;
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        if($request->hasFile('bill')){
            $file = $request->file('bill');
            $file_name = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/files/'), $file_name);
            $expense->bill = 'files/' . $file_name;
        }
        $expense->expense_by = $request->expense_by;

        $expense->save();

        if(! $request->ajax()){
            return redirect('expenses')->with('success', _lang('Information has been added'));
        }else{
            return response()->json(['result'=>'success', 'redirect'=> url('expenses') , 'message'=>_lang('Information has been added')]);
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
        $expense = Expense::where('expenses.id', $id)->first();
        if(! $request->ajax()){
            return view('backend.expenses.show', compact('expense'));
        }else{
            return view('backend.expenses.modal.show', compact('expense'));
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id, $status)
    {
        $expense = Expense::find($id);
        if($expense->status == 0){
            $expense->status = $status;
            $expense->save();
            if($status == 1){
                $transaction= new Transaction();
                $transaction->trans_date = Carbon::now()->format('Y-m-d');
                $transaction->account_id = $request->account_id;
                $transaction->amount = $expense->amount;
                $transaction->chart_id = $request->chart_id;
                $transaction->trans_type = $request->trans_type;
                $transaction->dr_cr = $request->dr_cr;
                $transaction->payment_method_id = $request->payment_method_id;
                $transaction->create_user_id = \Auth::user()->id;
                $transaction->reference = $request->reference;
                $transaction->attachment = $expense->bill;
                $transaction->note = $request->note;
                $transaction->save();

                $status = _lang('Approved.');
            }elseif($status == 2){
                $status = _lang('Rejected.');
            }
            if(! $request->ajax()){
                return redirect('expenses')->with('success', _lang('Expense request has been ') . $status);
            }else{
                return response()->json(['result' => 'success', 'redirect' => url('expenses'), 'message' => _lang('Expense request has been ') . $status]);
            }
        }
        
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function selection(Request $request, $id)
    {
        $expense = Expense::find($id);
        if(! $request->ajax()){
            return view('backend.expenses.selection', compact('expense'));
        }else{
            return view('backend.expenses.modal.selection', compact('expense'));
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
        $expense = Expense::where('id', $id)->where('status', 0)->first();
        $expense->delete();
        if(! $request->ajax()){
            return back()->with('success', _lang('Information has been deleted'));
        }else{
            return response()->json(['result'=>'success','message'=>_lang('Information has been deleted')]);
        }
    }
}
