<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\UniqueStandard;
use App\HostelCategory;
use App\Hostel;

class HostelCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = HostelCategory::select('*','hostel_categories.id AS id','hostel_categories.note AS note')
                                    ->join('hostels','hostels.id','=','hostel_categories.hostel_id')
                                    ->orderBy('hostel_categories.id', 'DESC')
                                    ->get();
        return view('backend.hostel.categories.category-list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.hostel.categories.category-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'hostel_id' => 'required',
            'standard' =>['required', new UniqueStandard($request->hostel_id,$request->standard)],
            'hostel_fee' => 'required|numeric',
            'note' => 'nullable',
        ]);
        $category = new HostelCategory();
        $category->hostel_id = $request->hostel_id;
        $category->standard = $request->standard;
        $category->hostel_fee = $request->hostel_fee;
        $category->note = $request->note;
        $category->save();

        return redirect('hostelcategories')->with('success', _lang('Information has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = HostelCategory::find($id);
        return view('backend.hostel.categories.category-edit',compact('category'));
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
        $this->validate($request, [
            'hostel_id' => 'required',
            'standard' => 'required',
            'hostel_fee' => 'required|numeric',
            'note' => 'nullable',
        ]);
        $category = HostelCategory::find($id);
        $category->hostel_id = $request->hostel_id;
        $category->standard = $request->standard;
        $category->hostel_fee = $request->hostel_fee;
        $category->note = $request->note;
        $category->save();

        return redirect('hostelcategories')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = HostelCategory::find($id);
        $category->delete();
        return redirect('hostelcategories')->with('success', _lang('Information has been deleted'));
    }
}
