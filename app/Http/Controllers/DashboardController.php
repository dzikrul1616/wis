<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\UserApplication;
use Auth;
class DashboardController extends Controller
{
    public function index()
    {
        // Memeriksa apakah pengguna sudah masuk dan tingkat aksesnya adalah "admin"
        if (Auth::check() && Auth::user()->level == 'admin') {
            $partner = Partner::where('status_partner', 'PENDING')->get();
            $data = [
                'partner' => $partner
            ];
            return view('admin.dashboard', $data);
        } else {
            // Jika pengguna belum masuk atau tingkat akses bukan "admin", alihkan ke halaman lain atau berikan respons sesuai kebutuhan Anda.
            return redirect('/')->withErrors(['error', 'You dont have access to this page!']);
        }
    }

    public function partner(Request $request)
    {
        $session = session('partner_id');
        $selectedStatus = $request->input('status');

        $query = UserApplication::where('partner_id', $session);

        if (!empty($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $applications = $query->get();

        $labels = ['Pending', 'Accepted', 'Rejected'];
        $data = [
            $applications->where('status', 'PENDING')->count(),
            $applications->where('status', 'ACCEPTED')->count(),
            $applications->where('status', 'REJECTED')->count()
        ];

        $partner = Partner::where('status_partner', 'PENDING')->get();

        $data = [
            'partner' => $partner,
            'labels' => $labels,
            'data' => $data,
            'applications' => $applications
        ];

        return view('partner.dashboard-partner', $data);
    }



}
