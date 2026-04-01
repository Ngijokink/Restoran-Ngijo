<?php
namespace App\Handlers;

use App\Http\Requests\Auth\AdminRequest;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthHandler
{
    protected $repo;
    protected $model;

    public function __construct(AuthInterface $repo, User $model)
    {
        $this->repo  = $repo;
        $this->model = $model;
    }

    // -------------------------------------------------------------------------
    // REGISTER
    // -------------------------------------------------------------------------

    /**
     * Register user biasa (role: user).
     * Bisa dilakukan siapa saja (public).
     */
    public function register($request)
    {
        return $this->repo->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'pelanggan',
        ]);
    }

    /**
     * Register admin baru.
     * Hanya boleh dipanggil oleh superadmin.
     */
    public function registerAdmin($request)
    {
        return $this->repo->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'admin',
        ]);
    }

    // -------------------------------------------------------------------------
    // LOGIN / LOGOUT
    // -------------------------------------------------------------------------

    public function login($request)
{
    $user = $this->repo->findEmail($request->email);

    if (!$user || !Hash::check($request->password, $user->password)) {
        return null;
    }

    $tokenName = match($user->role) {
        'superadmin' => 'superadmin_token',
        'admin'      => 'admin_token',
        'manager'    => 'manager_token',
        'staff'      => 'staff_token',
        default      => 'user_token',
    };

    $token = $user->createToken($tokenName)->plainTextToken;

    return [
        'id_user' => $user->id_user,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role,
        $tokenName => $token
    ];
}

    // -------------------------------------------------------------------------
    // UPDATE ROLE
    // -------------------------------------------------------------------------

    /**
     * Hierarki role (semakin tinggi angka = semakin tinggi level).
     */
    private function roleLevel(): array
    {
        return [
            'superadmin' => 4,
            'admin'      => 3,
            'manager'    => 2,
            'staff'      => 1,
            'pelanggan'  => 0,
        ];
    }

    /**
     * Validasi & eksekusi perubahan role.
     *
     * Aturan:
     * 1. Tidak boleh mengubah role diri sendiri.
     * 2. Hanya superadmin yang bisa mengangkat/menurunkan admin.
     * 3. Tidak bisa mengubah role user yang levelnya >= level auth.
     * 4. Tidak bisa memberikan role yang >= level auth.
     * 5. Tidak boleh ada 2 superadmin.
     */
    public function updateRole($request, User $targetUser): User
    {
        $data     = $request->validated();
        $authUser = auth()->user();
        $newRole  = $data['role'];
        $roles    = $this->roleLevel();

        $authLevel   = $roles[$authUser->role];
        $targetLevel = $roles[$targetUser->role];
        $newLevel    = $roles[$newRole];

        // 1. Tidak boleh ubah role sendiri
        
        // 2. Tidak bisa sentuh superadmin (kecuali sesama superadmin — mustahil karena hanya 1)
        if ($targetLevel >= $authLevel) {
            throw new \Exception('Tidak bisa mengubah role user dengan level yang sama atau lebih tinggi dari kamu.');
        }

        // 3. Tidak bisa memberikan role >= level auth
        if ($newLevel >= $authLevel) {
            throw new \Exception('Tidak bisa memberikan role lebih tinggi atau sama dengan role kamu.');
        }

        // 4. Jika role tujuan adalah superadmin — blok (superadmin hanya 1, dari registerSuperAdmin)
        if ($newRole === 'superadmin') {
            throw new \Exception('Role superadmin tidak dapat diberikan melalui fitur ini.');
        }

        // 5. Admin hanya bisa ubah role di bawah admin (manager, staff, user)
        //    Ini sudah tercakup oleh rule #3, tapi kita eksplisitkan pesannya
        if ($authUser->role === 'admin' && $newRole === 'admin') {
            throw new \Exception('Admin tidak bisa memberikan role admin kepada user lain.');
        }

        // Simpan perubahan
        $targetUser->role = $newRole;
        $targetUser->save();

        return $targetUser;
    }
}