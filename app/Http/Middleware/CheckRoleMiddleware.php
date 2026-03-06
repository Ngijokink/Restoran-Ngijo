<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleMiddleware
{
    /**
     * Hierarki role — semakin tinggi angka, semakin tinggi akses.
     */
    private array $roleLevel = [
        'superadmin' => 4,
        'admin'      => 3,
        'manager'    => 2,
        'staff'      => 1,
        'pelanggan'  => 0,
    ];

    public function handle(Request $request, Closure $next, string $requiredRole): mixed
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated.',
                'data'    => null,
            ], 401);
        }

        $userLevel     = $this->roleLevel[$user->role]     ?? -1;
        $requiredLevel = $this->roleLevel[$requiredRole]   ?? 999;

        // User bisa akses kalau levelnya >= level yang dibutuhkan
        // Contoh: superadmin (4) bisa akses route yang butuh role:admin (3)
        if ($userLevel < $requiredLevel) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kamu tidak punya akses ke halaman ini.',
                'data'    => null,
            ], 403);
        }

        return $next($request);
    }
}