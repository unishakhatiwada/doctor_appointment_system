<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

      if(Auth::attempt($request->only('email', 'password')))
      {
          return redirect()->route('admin.dashboard');
      }
      return back()->withErrors([
          'email' => 'The provided credentials do not match our records.',
      ]);
    }




    // Handle logout request
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }
}
