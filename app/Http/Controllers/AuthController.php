<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Group;
use App\Models\SystemLog;

class AuthController extends Controller
{
    public function login()
    {
        return view('login', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Admin Login"
        ]);
    }

    public function register()
    {
        return view('register', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Admin Registration",
            "groups" => Group::all()
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('login', true);

            $input['user_name'] = auth()->user()->name;
            $input['activity'] = "Login";
            $input['page'] = "Login";
            SystemLog::create($input);
            
            return redirect()->intended('/dashboard/choose-type');

            
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
            'group' => 'required'
        ]);
        $data = $request->except('confirm-password', 'password');
        $data['password'] = Hash::make($request->password);
        User::create($data);
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        $input['user_name'] = auth()->user()->name;
        $input['activity'] = "Logout";
        $input['page'] = "Logout";
        SystemLog::create($input);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

       

        return redirect('/login');
    }
}
