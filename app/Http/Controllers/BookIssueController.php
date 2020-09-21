<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LibraryMember;
use App\BookIssue;
use Carbon\Carbon;
class BookIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $library_id = '')
    {
        $issues = [];
        $member = '';
        if($request->all() != []){
            return redirect('bookissues/list/'.$request->library_id);
        }
        if($library_id != ''){
            $member = LibraryMember::join('users','users.id','=','library_members.user_id')->where('library_members.library_id',$library_id)->first();
            $issues = BookIssue::select('*','book_issues.id AS id')
                                ->join('books','books.id','=','book_issues.book_id')
                                ->join('book_categories','book_categories.id','=','books.category_id')
                                ->where('book_issues.library_id',$library_id)
                                ->orderBy('book_issues.id', 'DESC')
                                ->get();
        }
        return view('backend.library.issues.issue-index',compact('issues','member','library_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.library.issues.issue-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $toDay = Carbon::now()->toDateString();
        $this->validate($request, [
            'library_id' => 'required',
            'book_id' => 'required',
            'due_date' => 'required|date|date_format:"Y-m-d"|after:'.$toDay,
        ]);

        $issue = new BookIssue();
        $issue->library_id = $request->library_id;
        $issue->book_id = $request->book_id;
        $issue->note = $request->note;
        $issue->issue_date = $toDay;
        $issue->due_date = $request->due_date;
        $issue->save();

        return redirect('bookissues/list/'.$request->library_id)->with('success', _lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issue = BookIssue::select('*','users.name AS member_name','book_issues.status AS status')
                            ->join('library_members','library_members.library_id','=','book_issues.library_id')
                            ->join('users','users.id','=','library_members.user_id')
                            ->join('books','books.id','=','book_issues.book_id')
                            ->join('book_categories','book_categories.id','=','books.category_id')
                            ->where('book_issues.id',$id)
                            ->first();

        return view('backend.library.issues.issue-view',compact('issue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issue = BookIssue::find($id);
        return view('backend.library.issues.issue-edit',compact('issue'));
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
        $toDay = Carbon::now()->toDateString();
        $this->validate($request, [
            'library_id' => 'required',
            'book_id' => 'required',
            'due_date' => 'required',
        ]);

        $issue = BookIssue::find($id);
        $issue->library_id = $request->library_id;
        $issue->book_id = $request->book_id;
        $issue->note = $request->note;
        $issue->due_date = $request->due_date;
        $issue->save();
        
        return redirect('bookissues/list/'.$request->library_id)->with('success', _lang('Information has been updated'));
    }

     /**
     * Book Return the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function book_return($id)
    {
        $toDay = Carbon::now()->toDateString();
        $issue = BookIssue::find($id);
        $issue->return_date = $toDay;
        $issue->status = 2;
        $issue->save();
        return redirect('bookissues/list/'.$issue->library_id)->with('success', _lang('Book has been returned'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $issue = BookIssue::find($id);
        $issue->delete();
        return back()->with('success', _lang('Information has been deleted'));
    }
}
