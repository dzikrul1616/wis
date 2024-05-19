<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use App\Models\Partner;
use App\Models\OpenDays;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Facades\Redirect;
use DB;

class PartnerController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'partner_name' => 'required|string|max:100|unique:partners',
            'partner_email' => 'required|email|unique:partners',
            'partner_password' => 'required|min:5',
            'partner_phone' => 'required|string|unique:partners',
            'phone_prefix' => 'required|string',
            'partner_image' => 'required|max:2048|image',
            'license' => 'nullable|max:2048|mimes:pdf',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $partner = new Partner();
        $partner->partner_name = $request->input('partner_name');
        $partner->partner_email = $request->input('partner_email');
        $partner->partner_password = Hash::make($request->input('partner_password'));
        $partner->status_partner = 'PENDING';
        $partner->partner_phone = $request->input('phone_prefix') . $request->input('partner_phone');
        if ($request->hasFile('partner_image')) {
            $image = $request->file('partner_image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('partner/photo'), $imageName);
            $partner->partner_image = $imageName;
        }
        $partner->country = $request->input('country');
        $partner->province = $request->input('province');
        $partner->address = $request->input('address');
        if ($request->hasFile('license')) {
            $image = $request->file('license');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('partner/license'), $imageName);
            $partner->license = $imageName;
        }
        $partner->latitude = $request->input('latitude');
        $partner->longitude = $request->input('longitude');
        $partner->save();
        return redirect()->back()->with('success', 'Thankyou for your registration as partner!! our team will review your application and will approve in 1x24 hours');
    }

    public function updateStatusPartner(Request $request, $id)
    {
        $rules = [
            'status_partner' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $partner = Partner::findOrFail($id);
        $partnerName = $partner->partner_name;
        $partnerEmail = $partner->partner_email;
        $wa = "wapp.my/6282232210746";
        $status = $request->status_partner;
        $title = "Your Registration has been $status";
        if($status == "ACCEPTED"){
            $url = env('APP_URL');
            $result["url"] = $url;
            $content = "
            <p>
                    Congratulation! We have received your registration.
                    <br>
                    You can now <a href='$url'>login</a> using your email and password</p>";
        }else{
                $content ="
                            <p>
                            We are sorry, your registration has been $status.
                            <br>
                            Please contact $wa to appeal
                        </p>";
        }
        $data = array(
            'to_name' => $partnerName,
            'to_email' => $partnerEmail,
            'title' => $title,
            'content' => $content
        );
        $mail = Mail::send('emails.partner_approval', $data, function($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])->subject($data['title']);
            $message->from("no-reply@elevate.com","WISEAPP");
        });
        $partner->status_partner = $request->status_partner;
        $partner->save();

        return redirect()->back()->with('success', 'Partner '.$partnerName.' Has successfully '.$status);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('partner_email', 'partner_password');
        $credentials['status_partner'] = 'ACCEPTED'; // Partner status yang diharapkan

        $partner = DB::table('partners')->where('partner_email', $credentials['partner_email'])->first();

        if (!$partner || $partner->status_partner !== $credentials['status_partner']) {
            return redirect()->back()->withInput($request->only('partner_email'))->withErrors([
                'login_failed' => 'The email or password you entered is incorrect or the partner status is not accepted.',
            ]);
        }

        // Validasi password
        if (!Hash::check($credentials['partner_password'], $partner->partner_password)) {
            return redirect()->back()->withInput($request->only('partner_email'))->withErrors([
                'login_failed' => 'The email or password you entered is incorrect or the partner status is not accepted.',
            ]);
        }

        // Jika login berhasil
        session(['partner_id' => $partner->id]);
        return redirect()->intended('/dashboard-partner'); // Ganti '/dashboard' dengan URL tujuan setelah login sukses
    }

    public function index()
    {
        $partner = Partner::get();
        $data = [
            'partner' => $partner
        ];
        return view('admin.partner.manage', $data);
    }
    public function details($id)
    {
        $partner = Partner::with('openDays')->findOrFail($id);
        $data = [
            'partner' => $partner
        ];
        return view('admin.partner.details', $data);
    }

    public function profile($id)
    {
        $partner = Partner::with('openDays')->findOrFail($id);
        $data = [
            'partner' => $partner
        ];
        return view('partner.profile', $data);
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'open_hour' => 'required',
            'closed_hour' => 'required',
            'days' => 'required|array',
            'days.*' => 'string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $partner = Partner::findOrFail($id);
        $partner->open_hour = $request->open_hour;
        $partner->closed_hour = $request->closed_hour;
        $partner->save();

        OpenDays::where('partner_id', $id)->delete();
        foreach ($request->days as $dayName) {
            $day = new OpenDays();
            $day->day = $dayName;
            $day->partner_id = $id;
            $day->save();
        }
        return redirect()->back()->with('success', 'Profile has successfully updated');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/')->with('success', 'Logout successfully.');
    }
}

