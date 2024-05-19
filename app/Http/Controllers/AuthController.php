<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\ValidationException;
use Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->level !== 'admin') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['You are not authorized to access the admin panel.'],
                ]);
            }

            return redirect()->intended('/dashboard')->with('success', 'Login Admin Successfully');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/')->with('success', 'Logout successfully.');
    }

}