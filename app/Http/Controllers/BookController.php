<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Image;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::select('*','books.id AS id')->join('book_categories','book_categories.id','=','books.category_id')->orderBy('books.id', 'DESC')->get();
        return view('backend.library.books.book-list',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.library.books.book-add');
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
            'name' => 'required|string|max:191',
            'category_id' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'rack_no' => 'required',
            'quantity' => 'required',
            'publish_date' => 'required',
            'photo' => 'nullable|image|max:5120',
        ]);

        $book = new Book();
        $book->name = $request->name;
        $book->category_id = $request->category_id;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->rack_no = $request->rack_no;
        $book->quantity = $request->quantity;
        $book->description = $request->description;
        $book->publish_date = $request->publish_date;

        if ($request->hasFile('photo')){
           $image = $request->file('photo');
           $ImageName = time().'.'.$image->getClientOriginalExtension();
           Image::make($image)->resize(160, 160)->save(base_path('public/uploads/images/books/') . $ImageName);
           $book->photo = $ImageName;
       }
       $book->save();

       return redirect('books')->with('success', _lang('Information has been added'));
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        return view('backend.library.books.book-show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        return view('backend.library.books.book-edit',compact('book'));
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
            'name' => 'required|string|max:191',
            'category_id' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'rack_no' => 'required',
            'quantity' => 'required',
            'publish_date' => 'required',
            'photo' => 'nullable|image|max:5120',
        ]);

        $book = Book::find($id);
        $book->name = $request->name;
        $book->category_id = $request->category_id;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->rack_no = $request->rack_no;
        $book->quantity = $request->quantity;
        $book->description = $request->description;
        $book->publish_date = $request->publish_date;

        if ($request->hasFile('photo')){
           $image = $request->file('photo');
           $ImageName = time().'.'.$image->getClientOriginalExtension();
           Image::make($image)->resize(160, 160)->save(base_path('public/uploads/images/books/') . $ImageName);
           $book->photo = $ImageName;
       }
       $book->save();

       return redirect('books')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return redirect('books')->with('success', _lang('Information has been deleted'));
    }
}
