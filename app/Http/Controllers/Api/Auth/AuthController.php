<?php

namespace App\Http\Controllers\Api\Auth;

use App\Handlers\AuthHandler;
use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisRequest;
use App\Http\Resources\Auth\AdminResource;
use App\Http\Resources\Auth\AuthResource;
use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $handler,
                $model;
        public function __construct( AuthHandler $handler, User $model){

        $this->handler = $handler;
        $this->model = $model;
    }
    public function register(RegisRequest $request){
      
        try{
        $request->validated();
        $user = $this->handler->register($request);
        $resource = new AuthResource($user);
        return ResponseHelpers::success($resource,'Akun Berhasil Dibuat');
        } catch(\Throwable $e){
            return ResponseHelpers::error(null, 'Gagal Melakukan Register');
        }
    }
    public function registerAdmin(RegisRequest $request){
      
        try{
        $request->validated();
        $admin = $this->handler->registerAdmin($request);
        $resource = new AdminResource($admin);
        return ResponseHelpers::success($resource,'Akmessage: un Berhasil Dibuat');
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

public function UpdateRole(AdminRequest $request, $id)
{
    $data = $request->validated();
    $user = $this->model->findOrFail($id);
    $user->role = $data['role'];
    $user->save();

    return ResponseHelpers::success($user,'Role User Berhasil Di Ubah');
}
public function User(){
    $user = $this->model->all();
    return ResponseHelpers::success($user,'Role User Berhasil Di Ubah');
}
}
