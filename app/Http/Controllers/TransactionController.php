<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    public function index()
    {
        $session = session('partner_id');
        $tr = Transaction::with('user')->where('partner_id', $session)->orderBy('created_at', 'desc')->get();

        $data = [
            'tr' => $tr,
        ];
        return view('partner.transaction.manage', $data);
    }

    public function verifyTransaction($id, Request $request)
    {
        $tr = Transaction::findOrFail($id);
        $tr->status = $request->status;
        $tr->save();

        if ($request->status === 'ACCEPTED') {
            $tpoint = $tr->transaction_point;
            $user_id = $tr->user_id;
            $user = User::findOrFail($user_id);
            if ($user->saldo >= $tpoint) {
                $user->saldo -= $tpoint;
                $user->save();
            } else {
                return redirect()->back()->with('error', 'Insufficient balance');
            }
        }
        return redirect()->back()->with('success', 'Transaction data has been '.$request->status);
    }

}
