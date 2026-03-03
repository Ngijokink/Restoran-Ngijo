<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
            ]);
        
        $create = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        
        ]);
        return response()->json([
            'message' => 'Akun Berhasil Dibuat',
            $create
        ]);
    }

    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
            ]);
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return null;
        }
        $token = $user->createToken('token_login')->plainTextToken;

        return $token;
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    }
}
