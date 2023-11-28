<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class ApiUserController extends Controller
{
    public function update_register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'fname' => 'nullable|min:3|max:50',
                'lname' => 'nullable|min:3|max:50',
                'password' => 'nullable|min:6|max:20',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('users')->ignore($request['id']),
                ],
                'phone' => 'nullable',
            ]);

            if (
                $request->filled('password') && $request->filled('password_confirmation')
                && $request->input('password') !== $request->input('password_confirmation')
            ) {
                $validator->errors()->add('password', 'A senha e a confirmação de senha não coincidem.');
            }

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400); // 400 é o código de status de erro de solicitação inválida
            }

            $user = User::find($request['id']);

            if ($request->filled('fname')) {
                $user->fname = $request['fname'];
            }

            if ($request->filled('lname')) {
                $user->lname = $request['lname'];
            }

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
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function save_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|min:3|max:50',
            'lname' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable',
            'password' => 'required|min:6|max:20',
        ]);

        if (
            $request->filled('password') && $request->filled('password_confirmation')
            && $request->input('password') !== $request->input('password_confirmation')
        ) {
            $validator->errors()->add('password', 'A senha e a confirmação de senha não coincidem.');
        }

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
}
