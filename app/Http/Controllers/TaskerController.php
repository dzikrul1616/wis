<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Vehicle;
use Validator;
use Auth;
use Hash;
use Illuminate\Support\Facades\Storage;

class TaskerController extends Controller
{
    public function index()
    {
        $vehicle = Vehicle::get();
        $client = new Client();
        $response = $client->request('GET', 'https://restcountries.com/v3.1/all');
        $countries = json_decode($response->getBody(), true);

        usort($countries, function ($a, $b) {
            return strcmp($a['name']['common'], $b['name']['common']);
        });
        $session = session('partner_id');
        $tasker = User::with('vehicle')->where('level', 'tasker')->where('partner_id', $session)->get();

        $data = [
            'countries' => $countries,
            'vehicle' => $vehicle,
            'tasker' => $tasker
        ];

        return view('partner.tasker.manage', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'full_name' => 'required|max:255',
            'username' => 'required|unique:users|string',
            'phone' => 'required|numeric',
            'email' => 'required|email:filter|max:255',
            'password' => 'required|min:5',
            'gender' => 'required',
            'birth_date' => 'required',
            'country' => 'required',
            'province' => 'required',
            'address' => 'required',
            'vehicle_id' => 'required',
            'partner_id' => 'required',
            'partner_image' => 'required|image|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tasker = new User();
        $tasker->full_name = $request->full_name;
        $tasker->username = $request->username;
        $tasker->phone = $request->phone;
        $tasker->email = $request->email;
        $tasker->password = $request->password;
        $tasker->level = 'tasker';
        $tasker->gender = $request->gender;
        $tasker->birth_date = $request->birth_date;
        $tasker->country = $request->country;
        $tasker->province = $request->province;
        $tasker->address = $request->address;
        $tasker->latitude = '-';
        $tasker->longitude = '-';
        $tasker->vehicle_id = $request->vehicle_id;
        $tasker->partner_id = $request->partner_id;
        $tasker->saldo = '0';
        $tasker->status = '1';
        if ($request->hasFile('partner_image')) {
            $image = $request->file('partner_image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('partner/tasker/'), $imageName);
            $tasker->photo = $imageName;
        }
        $tasker->save();
        return redirect()->back()->with('success', 'Tasker credentials created successfully');
    }
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $tasker = User::find($id);
        $tasker->status = $status;
        $tasker->save();
        return redirect()->back()->with('success', 'Tasker status updated successfully');
    }
    public function update($id, Request $request)
    {
        $rules = [
            'full_name' => 'required|max:255',
            'username' => 'required|unique:users,username,' . $id . '|string',
            'phone' => 'required|numeric',
            'email' => 'required|email:filter|max:255',
            'old_password' => 'nullable',
            'password' => 'nullable|min:5',
            'gender' => 'required',
            'birth_date' => 'required',
            'country' => 'required',
            'province' => 'required',
            'address' => 'required',
            'vehicle_id' => 'required',
            'partner_id' => 'required',
            'partner_image' => 'required|image|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $tasker = User::findOrFail($id);
        $tasker->full_name = $request->full_name;
        $tasker->username = $request->username;
        $tasker->phone = $request->phone;
        $tasker->email = $request->email;
        if ($request->filled('password')) {
            $tasker->password = $request->password;
        } else {
            $tasker->password = $request->old_password;
        }
        $tasker->level = 'tasker';
        $tasker->gender = $request->gender;
        $tasker->birth_date = $request->birth_date;
        $tasker->country = $request->country;
        $tasker->province = $request->province;
        $tasker->address = $request->address;
        $tasker->vehicle_id = $request->vehicle_id;
        $tasker->partner_id = $request->partner_id;
        if ($request->hasFile('partner_image')) {
            if ($tasker->photo != null) {
                  $oldImage = public_path('partner/tasker/' . $tasker->photo);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $image = $request->file('partner_image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('partner/tasker/'), $imageName);
            $tasker->photo = $imageName;
        }
        $tasker->save();
        return redirect()->back()->with('success', 'Tasker credentials updated successfully');
    }


    public function delete($id)
    {
        $tasker = User::findOrFail($id);
        if ($tasker) {
            if ($tasker->photo != null) {
                $oldImage = public_path('partner/tasker/' . $tasker->photo);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $tasker->delete();
            return redirect()->back()->with('success', 'Tasker credentials deleted successfully');
        }
        return redirect()->back()->with('error', 'Education not found');
    }

    public function admin()
    {
        $tasker = User::with([
            'partner',
            'vehicle'
        ])->where('level','tasker')->get();
        $data = [
            'tasker' => $tasker
        ];
        return view('admin.tasker.manage', $data);
    }
    public function details($id)
    {
        $tasker = User::with([
            'partner',
            'vehicle'
        ])->where('level','tasker')->findOrFail($id);
        $data = [
            'tasker' => $tasker
        ];
        return view('admin.tasker.details', $data);
    }
}
