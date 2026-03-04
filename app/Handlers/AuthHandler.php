<?php
namespace App\Handlers;

use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Hash;

class AuthHandler{
    protected $repo;
    public function __construct(AuthInterface $repo){
        $this->repo = $repo;
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
}