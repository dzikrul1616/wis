<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserApplication;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Support\Facades\Mail;
use DB;
use Validator;

class UserPartnerController extends Controller
{
    public function index($id)
    {
        $users = DB::table('users')
            ->join('user_applications', 'users.id', '=', 'user_applications.user_id')
            ->where('user_applications.partner_id', $id)
            ->selectRaw('users.id AS user_id, users.*, user_applications.status, user_applications.*')
            ->get();

        $data = [
            'user' => $users
        ];
        return view('partner.user.manage', $data);
    }

    public function detail($id, $user_id)
    {
        $users = DB::table('users')
            ->join('user_applications', 'users.id', '=', 'user_applications.user_id')
            ->where('users.id', $user_id)
            ->where('user_applications.id', $id)
            ->select('users.*', 'user_applications.*')
            ->get();

        $data = [
            'user' => $users
        ];
        return view('partner.user.details', $data);
    }

    public function updateStatusUser(Request $request, $id)
    {
        $user_id = $request->user_id;
        $rules = [
            'status_user' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userApplication = UserApplication::findOrFail($id);
        $user = $userApplication->user; // Mengambil relasi model User

        $userName = $request->full_name;
        $userEmail = $request->email;
        $wa = "wa.me/6282232210746";
        $status = $request->status_user;
        $title = "Your Application has been $status";

        if ($status == "ACCEPTED") {
            $url = env('APP_URL');
            $result["url"] = $url;
            $content = "
                <p>
                    Congratulation! We have received your application.
                    <br>
                    You can now <a href='$url'>login</a> using your email and password
                </p>";
            $update = User::findOrFail($user_id);
            $update->partner_id = $userApplication->partner_id;
            $update->save();
        } else {
            $content = "
                <p>
                    We are sorry, your application has been $status.
                    <br>
                    Please contact $wa to appeal
                </p>";
        }

        $data = array(
            'to_name' => $userName, // Mengubah $partnerName menjadi $userName
            'to_email' => $userEmail,
            'title' => $title,
            'content' => $content
        );

        $mail = Mail::send('emails.partner_approval', $data, function ($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])->subject($data['title']);
            $message->from("no-reply@elevate.com", "WISEAPP");
        });

        $userApplication->status = $request->status_user; // Memperbarui status_user pada model UserApplication
        $userApplication->save();

        return redirect()->back()->with('success', 'User ' . $userName . ' has been successfully ' . $status);
    }
    public function delete($id)
    {
        $userApplication = UserApplication::findOrFail($id);
        $user = $userApplication->user;
        $username = $user->username; // Mengambil username dari objek user
        $partner = $userApplication->partner;
        $wa = "wa.me/" . $partner->partner_phone;
        $status = "dropped out";
        $title = "We dropped you out from our partner";

        $content = "
            <p>
                We are sorry, we have dropped you out from our partner.
                <br>
                Please contact $wa for further information.
            </p>";

        $data = array(
            'to_name' => $username,
            'to_email' => $user->email, // Mengambil email dari objek user
            'title' => $title,
            'content' => $content
        );

        $mail = Mail::send('emails.partner_approval', $data, function ($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])->subject($data['title']);
            $message->from("no-reply@elevate.com", "WISEAPP");
        });
        $userApplication->delete();
        return redirect()->back()->with('success', 'User ' . $username . ' has been successfully ' . $status);
    }







}
