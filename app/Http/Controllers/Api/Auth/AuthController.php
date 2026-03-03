<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisRequest;
use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $repo;
        public function __construct(AuthInterface $repo){
        $this->repo = $repo;
    }
    public function register(RegisRequest $request){
      
        $request->validated();
        $create = $this->repo->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        
        ]);
        return response()->json([
            'message' => 'Akun Berhasil Dibuat',
            $create
        ]);
    }

    public function login(LoginRequest $request){

        $request->validated();
        $user = $this->repo->findEmail($request);
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
