<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login()
    {
        if (!Auth::check()) {
            return view('pages.login');
        } else {
            return redirect('/');
        }
    }

    public function register()
    {
        if (!Auth::check()) {
            return view('pages.register');
        } else {
            return redirect('/');
        }
    }

    public function dashboard()
    {
        $users = User::all()->toArray();

        return view('dashboard', compact('users'));
    }

    public function dados($id)
    {
        $user = User::find($id);
        $loggedUser = Auth::user();

        if (!$loggedUser || ($loggedUser->id != $id && $loggedUser->role != '4')) {
            return redirect('/');
        }

        return view('pages.dados', compact('user', 'id'));
    }

    public function update_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($request['id']),
            ],
            'phone' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::find($request['id']);

        if ($request->filled('email')) {
            $user->email = $request['email'];
        }

        if ($request->filled('phone')) {
            $user->phone = $request['phone'];
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request['password']);
        }

        $user->save();
        return response()->json(['success' => 'Dados atualizados com sucesso!']);
    }

    public function save_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = new User;
        $user->name = 'default';
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->password = bcrypt($request['password']);

        $user->save();
        return response()->json(['success' => 'Usuário registrado com sucesso']);
    }

    public function delete_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::find($request['id']);
        
        $user->delete();
        return response()->json(['success' => 'Usuário excluído com sucesso']);
    }

    public function user_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])) {
            $user = Auth()->user();
            return response()->json(['success' => 'Successfully Logged In']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
