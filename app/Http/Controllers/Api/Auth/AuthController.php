<?php

namespace App\Http\Controllers\Api\Auth;

use App\Handlers\AuthHandler;
use App\Helpers\ResponseHelpers;
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
        return ResponseHelpers::success($user,'Akun Berhasil Dibuat');
        } catch(\Throwable $e){
            return ResponseHelpers::error(null, 'Gagal Melakukan Register');
        }
    }
    public function registerAdmin(RegisRequest $request){
      
        try{
        $request->validated();
        $user = $this->handler->registerAdmin($request);
        return ResponseHelpers::success($user,'Akun Berhasil Dibuat');
        } catch(\Throwable $e){
            return ResponseHelpers::error(null, 'Gagal Melakukan Register');
        }
    }

    public function login(LoginRequest $request)
{
    try {

        $request->validated();
        $token = $this->handler->login($request);

        if (!$token) {
            return ResponseHelpers::error(null, 'Email atau password salah', 401);
        }

        return ResponseHelpers::success($token, 'Login berhasil');

    } catch (\Throwable $e) {
        return ResponseHelpers::error(null, $e->getMessage(), 500);
    }
}

public function logout(Request $request)
{
    try {

        $request->user()->currentAccessToken()->delete();

        return ResponseHelpers::success(null, 'Logout berhasil');

    } catch (\Throwable $e) {
        return ResponseHelpers::error(null, $e->getMessage(), 500);
    }
}
}
