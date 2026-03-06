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

class AuthController extends Controller
{
    protected $handler;
    protected $model;

    public function __construct(AuthHandler $handler, User $model)
    {
        $this->handler = $handler;
        $this->model   = $model;
    }

    // -------------------------------------------------------------------------
    // REGISTER
    // -------------------------------------------------------------------------

    /**
     * Register user biasa — public.
     */
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

    /**
     * Register admin baru — hanya superadmin.
     * Middleware: auth:sanctum + role:superadmin
     */
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

    /**
     * Register superadmin — hanya bisa 1 kali (superadmin belum ada).
     * Sebaiknya endpoint ini dihapus atau dilindungi setelah setup awal.
     * Untuk keamanan, route ini bisa dihapus setelah superadmin pertama dibuat.
     */
    public function registerSuperAdmin(RegisRequest $request)
    {
        try {
            $request->validated();
            $admin    = $this->handler->registerSuperAdmin($request);
            $resource = new AdminResource($admin);

            return ResponseHelpers::success($resource, 'Akun superadmin berhasil dibuat.');
        } catch (\Throwable $e) {
            return ResponseHelpers::error(null, $e->getMessage(), 422);
        }
    }

    // -------------------------------------------------------------------------
    // LOGIN / LOGOUT
    // -------------------------------------------------------------------------

    public function login(LoginRequest $request)
    {
        try {
            $request->validated();
            $result = $this->handler->login($request);

            if (!$result) {
                return ResponseHelpers::error(null, 'Email atau password salah.', 401);
            }

            return ResponseHelpers::success($result, 'Login berhasil.');
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

    // -------------------------------------------------------------------------
    // ROLE MANAGEMENT
    // -------------------------------------------------------------------------

    /**
     * Update role user tertentu.
     * - Superadmin: bisa ubah semua role di bawahnya (admin, manager, staff, user).
     * - Admin     : bisa ubah manager, staff, user — TIDAK bisa ubah admin/superadmin.
     */
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

    // -------------------------------------------------------------------------
    // USER LIST
    // -------------------------------------------------------------------------

    /**
     * Ambil semua user.
     * - Superadmin: lihat semua user.
     * - Admin     : lihat semua user kecuali superadmin.
     */
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