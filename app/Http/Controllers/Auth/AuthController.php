<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function unauthorized(){
        return view('layouts.unauthorized-user');
    }
    public function postLogin(Request $request)
    {
        // dd(Hash::make($request->password));
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $credential = $request->only('email','password');
        if(Auth::attempt($credential))
        {
            if(auth()->user()->status == 1){
                return redirect()->intended('product/index')->withSuccess('You have successfully loggedin');
            }
                return redirect()->intended('/')->withSuccess('You have successfully loggedin');

        }else{
            return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
        }
    }
    public function registration()
    {
        return view('auth.registration');
    }
    public function postregistration(Request $request)
    {
        $password = Hash::make($request->password);
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$password
        ]);
        return redirect('login')->withSuccess('message', 'SUccessfully registered');
    }

    //logout
        public function logout() {
            Session::flush();
            Auth::logout();

            return Redirect('login');
        }
}
