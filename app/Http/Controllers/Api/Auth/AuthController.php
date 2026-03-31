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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    protected $handler;
    protected $model;

    public function __construct(AuthHandler $handler, User $model)
    {
        $this->handler = $handler;
        $this->model   = $model;
    }

    public function register(RegisRequest $request)
    {
        try {
            $request->validated();
            $user     = $this->handler->register($request);
            $resource = new AuthResource($user);

            return ResponseHelpers::success($resource, 'Akun berhasil dibuat.');
        } catch (\Throwable $e) {
            return ResponseHelpers::error(null, 'Gagal melakukan register.' . $e->getMessage(), 500);
        }
    }

    public function registerAdmin(RegisRequest $request)
    {
        try {
            $request->validated();
            $admin    = $this->handler->registerAdmin($request);
            $resource = new AdminResource($admin);

            return ResponseHelpers::success($resource, 'Akun admin berhasil dibuat.');
        } catch (\Throwable $e) {
            return ResponseHelpers::error(null, $e->getMessage(), 500);
        }
    }

    public function registerSuperAdmin(RegisRequest $request)
    {
        try {
            $request->validated();
            $admin    = $this->handler->registerSuperAdmin($request);
            $resource = new AdminResource($admin);

            return ResponseHelpers::success($resource, 'Akun superadmin berhasil dibuat.');
        } catch (\Throwable $e) {
            return ResponseHelpers::error(null, $e->getMessage(), 403);
        }
    }

    public function login(LoginRequest $request)
{
    try {
        $request->validated();
        $result = $this->handler->login($request);

        if (!$result) {
            return ResponseHelpers::error(null, 'Email atau password salah.', 401);
        }
        $cacheKey = "users_" . $result['id_user'];

        $user = Cache::remember($cacheKey, 60, function () use ($result) {
            return $result;
        });

        return ResponseHelpers::success($user, 'Login berhasil.');

    } catch (\Throwable $e) {
        return ResponseHelpers::error(null, $e->getMessage(), 500);
    }
}

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return ResponseHelpers::success(null, 'Logout berhasil.');
        } catch (\Throwable $e) {
            return ResponseHelpers::error(null, $e->getMessage(), 500);
        }
    }

    public function updateRole(AdminRequest $request, $id)
{
    try {
        $user   = $this->model->findOrFail((int) $id); // cast ke int
        $result = $this->handler->updateRole($request, $user);

        return ResponseHelpers::success(new AdminResource($result), 'Role user berhasil diubah.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return ResponseHelpers::error(null, 'User tidak ditemukan.', 404);
    } catch (\Exception $e) {
        return ResponseHelpers::error(null, $e->getMessage(), 403);
    }
}


    public function users()
    {
        try {
            $authUser = auth()->user();

            if ($authUser->role === 'superadmin') {
                $users = $this->model->all();
            } else {
                // Admin tidak perlu tahu superadmin ada
                $users = $this->model->where('role', '!=', 'superadmin')->get();
            }

            return ResponseHelpers::success($users, 'Data user berhasil diambil.');
        } catch (\Throwable $e) {
            return ResponseHelpers::error(null, $e->getMessage(), 500);
        }
    }
}