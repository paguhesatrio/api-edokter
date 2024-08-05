<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    
    public function index()
    {
        return view('login', [
            "title" => 'Login',
        ]);
    }
    
    public function authenticate(Request $request)
     {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            
            return redirect()->intended('/home');
        }
        return back()->with('loginError', 'Login Failed!!!');

     }

     public function logout(Request $request)
     {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
     }
}
