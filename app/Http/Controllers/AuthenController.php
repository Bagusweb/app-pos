<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenController extends Controller
{
    public function showlogin(){
        return view('authen.login');
    }


    public function proseslogin(Request $request){
       $request->validate([
       'email' => 'required|string',
       'password' => 'required|string',
    ]);
       
       $user = Users::where('email', $request->input('email'))->first();

       if($user && Hash::check($request->input('password'), $user->password)) {
        Auth::login($user);

        if(Auth::user()->role == 'Admin') {
            return redirect()->intended('/admindashboard')->with('success', 'You have Successfully loggedin');
        } else {
            return redirect()->intended('/cashierdashboard')->with('success', 'You have Successfully loggedin');
        }
       } else {
        return redirect()->route('login')->with('success', 'Invalid login credentials');
       }


    }

    public function showregister(){
        return view('authen.register');
    }

    public function prosesregister(Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tbl_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Users::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'Cashier'
        ]);

        return redirect(route('login')); 
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }
}

  
