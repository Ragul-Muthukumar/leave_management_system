<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
   			]);
        }

    }
}
