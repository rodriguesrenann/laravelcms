<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-users');
    }

    public function index()
    {
        $users = User::paginate(10);
        $loggedId = Auth::user();
        return view('admin.users.index', [
            'users' => $users,
            'loggedId' => $loggedId->id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'unique:users|max:100|string|email',
            'password' => 'confirmed|min:4|required|string'
        ];

        $validator = Validator::make($data, $rules);

        if (!$validator->fails()) {
            
            $newUser = new User();
            $newUser->name = $data['name'];
            $newUser->email = $data['email'];
            $newUser->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $newUser->save();

            return redirect()->route('users.index');
        }

        return redirect()->route('users.create')->withErrors($validator)->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if ($user) {
            return view('admin.users.edit', [
                'user' => $user
            ]);
        }

        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {

            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            $validator = Validator::make([
                'name' => $data['name'],
                'email' => $data['email']
            ], [
                'name' => 'required|string|max:100',
                'email' => 'required|email|string|max:100'
            ]);

            if (!$validator->fails()) {

                $user->name = $data['name'];

                if ($user->email != $data['email']) {
                    $hasEmail = User::where('email', $data['email'])->first();
                    if (!$hasEmail) {
                        $user->email = $data['email'];
                    }

                    $validator->errors()->add('email', 'E-mail já cadastrado no sistema!');
                }

                if (!empty($data['password'])) {
                    if (strlen($data['password']) >= 4) {
                        if ($data['password'] == $data['password_confirmation']) {
                            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                        } else {
                            $validator->errors()->add('password', 'As senhas não coincidem!');
                        }
                    } else {
                        $validator->errors()->add('password', 'A senha deve conter ao menos 4 caracteres!');
                    }
                }

                if(count($validator->errors()) > 0) {
                    return redirect()->route('users.edit', ['user' => $user->id])->withErrors($validator);
                }

                $user->save();
                
                return redirect()->route('users.index');
            }



            return redirect()->route('users.edit', ['user' => $user->id])->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $loggedId = Auth::id();

        if ($user && $loggedId != $user->id) {
            $user->delete();
        }

        return redirect()->route('users.index')->with('Usuário inexistente!');
    }
}
