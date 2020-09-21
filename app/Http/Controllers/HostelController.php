<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hostel;

class HostelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hostels = Hostel::orderBy('id', 'DESC')->get();
        return view('backend.hostel.hostels.hostel-list',compact('hostels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.hostel.hostels.hostel-add');
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
            'hostel_name' => 'required',
            'type' => 'required',
            'address' => 'required',
            'note' => 'nullable',
        ]);
        $hostel = new Hostel();
        $hostel->hostel_name = $request->hostel_name;
        $hostel->type = $request->type;
        $hostel->address = $request->address;
        $hostel->note = $request->note;
        $hostel->save();

        return redirect('hostels')->with('success', _lang('Information has been added'));
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
        $hostel = Hostel::find($id);
        return view('backend.hostel.hostels.hostel-edit',compact('hostel'));
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
            'hostel_name' => 'required',
            'type' => 'required',
            'address' => 'required',
            'note' => 'nullable',
        ]);
        $hostel = Hostel::find($id);
        $hostel->hostel_name = $request->hostel_name;
        $hostel->type = $request->type;
        $hostel->address = $request->address;
        $hostel->note = $request->note;
        $hostel->save();
        
        return redirect('hostels')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hostel = Hostel::find($id);
        $hostel->delete();
        return redirect('hostels')->with('success', _lang('Information has been deleted'));
    }
}
