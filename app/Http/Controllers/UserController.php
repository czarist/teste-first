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

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
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
}
