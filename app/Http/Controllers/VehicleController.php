<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Validator;


class VehicleController extends Controller
{
    public function index()
    {
        $vehicle = Vehicle::get();
        $data = [
            'vehicle' => $vehicle
        ];
        return view('partner.vehicle.manage', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'vehicle' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $vehicle = new Vehicle();
        $vehicle->vehicle_type = $request->vehicle;
        $vehicle->save();
        return redirect()->back()->with('success', 'Vehicle type created successfully');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'vehicle' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->vehicle_type = $request->vehicle;
        $vehicle->save();
        return redirect()->back()->with('success', 'Vehicle type updated successfully.');
    }

    public function delete($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return redirect()->back()->with('success', 'Vehicle type deleted successfully.');
    }
}
