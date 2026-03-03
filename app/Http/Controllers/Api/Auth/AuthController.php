<?php

namespace App\Http\Controllers\Api\Auth;

use App\Handlers\AuthHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisRequest;
use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $handler;
        public function __construct( AuthHandler $handler){

        $this->handler = $handler;
    }
    public function register(RegisRequest $request){
      
        try{
        $request->validated();
        $user = $this->handler->register($request);
        return response()->json([
            'message' => 'Akun Berhasil Dibuat',
            $user
        ]);
        } catch(\Throwable $e){
            return response()->json($e->getMessage());
        }
    }

    public function login(LoginRequest $request)
{
    try {

        $request->validated();
        $token = $this->handler->login($request);

        if (!$token) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        return response()->json($token);

    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage()
        ]);
    }
}

    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
        } catch(\Throwable $e){
            return response()->json([
                $e->getMessage()
            ]);
        }
    }
}
