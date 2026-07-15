<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{


    $request->validate([
        'FullName' => 'required|max:100',
        'Email' => 'required|email|unique:patient,Email',
        'Password' => 'required|min:6|confirmed',
        'Gender' => 'required',
        'DOB' => 'required|date',
        'Phone' => 'required|max:20',
    ]);

    Patient::create([
        'FullName' => $request->FullName,
        'Email' => $request->Email,
        'Password' => Hash::make($request->Password),
        'Gender' => $request->Gender,
        'DOB' => $request->DOB,
        'Phone' => $request->Phone,
        'RegistrationDate' => now()->toDateString()
    ]);

    return redirect('/login')->with('success','Registration Successful!');

    }
    public function login(Request $request)
{
    $credentials = $request->only('email','password');
    $role = $request->input('role');

    if (Auth::guard($role)->attempt($credentials)) {
        return redirect("/{$role}/dashboard");
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}

}