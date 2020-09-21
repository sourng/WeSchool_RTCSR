<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookCategory;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BookCategory::orderBy('id', 'DESC')->get();
        return view('backend.library.categories.category-add',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'category_name' => 'required|string|max:80',
        ]);

        $category = new BookCategory();
        $category->category_name = $request->category_name;
        $category->save();

        return redirect('bookcategories')->with('success', _lang('Information has been added'));
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
        $category = BookCategory::find($id);
        $categories = BookCategory::orderBy('id', 'DESC')->get();
        return view('backend.library.categories.category-edit',compact('category','categories'));
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
            'category_name' => 'required|string|max:80',
        ]);

        $category = BookCategory::find($id);
        $category->category_name = $request->category_name;
        $category->save();

        return redirect('bookcategories')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = BookCategory::find($id);
        $category->delete();

        return redirect('bookcategories')->with('success', _lang('Information has been deleted'));
    }
}
