<?php
namespace App\Handlers;

use App\Http\Requests\Auth\AdminRequest;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthHandler{
    protected $repo;
    protected $model;
    public function __construct(AuthInterface $repo, User $model){
        $this->repo = $repo;
        $this->model = $model;
    }
    public function register($request){
        $create = $this->repo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return $create;
    }
    public function registerAdmin($request){
        $create = $this->repo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin'
        ]);
        return $create;
    }
    public function login($request)
{
    $user = $this->repo->findEmail($request->email);

    if (!$user || !Hash::check($request->password, $user->password)) {
            return null;
        }

    $token = $user->createToken('api_token')->plainTextToken;

    return [
        'token' => $token
    ];
}
public function updateRole($user)
{
    $authUser = auth()->user();

    if($authUser->role == 'admin' && $user->role == 'admin'){
        throw new \Exception('Tidak bisa mengubah role dengan level yang sama');
    }
}
}