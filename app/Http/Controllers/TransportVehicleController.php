<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransportVehicle  As Vehicle;
class TransportVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::all()->sortByDesc('id');
        return view('backend.transport.vehicles.vehicle-add',compact('vehicles'));
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
            'vehicle_name' => 'required',
            'serial_number' => 'required',
        ]);

        $vehicle = new Vehicle();
        $vehicle->vehicle_name = $request->vehicle_name;
        $vehicle->serial_number = $request->serial_number;
        $vehicle->save();
        
        return redirect('transportvehicles')->with('success', _lang('Information has been added'));
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
        $vehicle = Vehicle::find($id);
        $vehicles = Vehicle::all()->sortByDesc('id');
        return view('backend.transport.vehicles.vehicle-edit',compact('vehicles','vehicle'));
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
            'vehicle_name' => 'required',
            'serial_number' => 'required',
        ]);

        $vehicle = Vehicle::find($id);
        $vehicle->vehicle_name = $request->vehicle_name;
        $vehicle->serial_number = $request->serial_number;
        $vehicle->save();
        
        return redirect('transportvehicles')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        return redirect('transportvehicles')->with('success', _lang('Information has been deleted'));
    }
}
