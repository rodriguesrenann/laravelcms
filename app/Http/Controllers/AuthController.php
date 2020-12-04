<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller
{


    public function register()
    {
        return view('admin.register');
    }

    public function registerAction(Request $request)
    {
        $data = $request->all();

        $credentials = $request->only([
            'email',
            'password'
        ]);

        $rules = [
            'name' => 'required|max:100|string|min:3',
            'email' => 'required|unique:users|email|string|max:100',
            'password' => 'required|min:4|string|confirmed'
        ];

        $validator = Validator::make($data, $rules);

        if (!$validator->fails()) {
            $newUser = new User();
            $newUser->name = $data['name'];
            $newUser->email = $data['email'];
            $newUser->password = password_hash($data['password'], PASSWORD_DEFAULT);
            if(User::count() == 0) {
                $newUser->admin = 1;
            }
            $newUser->save();

            if (Auth::attempt($credentials)) {
                return redirect()->route('home');
            }
        }



        return redirect()->route('register')->withErrors($validator)->withInput();
    }

    public function login()
    {
        return view('admin.login');
    }

    public function loginAction(Request $request)
    {
        $data = $request->only([
            'email',
            'password'
        ]);
        $remember = $request->input('remember');

        $validator = Validator::make($data, [
            'email' => 'required|string|email',
            'password' => 'required|string' 	  
        ]);

        if(!$validator->fails()) {
            if(Auth::attempt($data, $remember)) {
                return redirect()->route('home');
            }
        }

        return redirect()->route('login')->withErrors($validator)->withInput();
    }

    public function logout() 
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
