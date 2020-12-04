<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $loggedUser = Auth::user();
        $user = User::find($loggedUser->id);

        if ($user) {
            return view('admin.profile.index', [
                'user' => $user
            ]);
        }

        return view('errors.unauthorized');
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);
        $loggedId = Auth::id();
        $user = User::find($loggedId);

        if ($user) {
            $validator = Validator::make($data, [
                'name' => 'required|max:100|min:3|string',
                'email' => 'required|max:100|email|string'
            ]);

            if (!$validator->fails()) {
                if ($user->email != $data['email']) {
                    $hasEmail = User::where('email', $data['email'])->first();
                    if (!$hasEmail) {

                        $user->email = $data['email'];;
                    } else {
                        $validator->errors()->add('email', 'E-mail ja cadastrado no sistema!');
                    }
                }

                if (!empty($data['password'])) {

                    if ($data['password'] == $data['password_confirmation']) {
                        if (strlen($data['password']) >= 4) {

                            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                        } else {
                            $validator->errors()->add('password', 'A senha deve ter no minimo quatro caracteres!');
                        }
                    } else {
                        $validator->errors()->add('password', 'As senhas não batem!');
                    }
                }

                if (count($validator->errors()) > 0) {

                    return redirect()->route('profile')->withErrors($validator)->withInput();
                }

                $user->name = $data['name'];
                $user->save();

                return redirect()->route('users.index');
            }


            return redirect()->route('profile')->withErrors($validator)->withInput();
        }
    }
}
