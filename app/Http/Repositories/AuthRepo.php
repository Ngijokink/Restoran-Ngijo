<?php
namespace App\Repositories;

use App\Models\User;
use App\Interfaces\AuthInterface;


class AuthRepo implements AuthInterface{
    protected $model;
    public function __construct(User $model){
        $this->model = $model;
    }

    public function findEmail($email){
        return $this->model->where('email', $email)->first();
    }
    public function create($data){
        return $this->model->create($data);
    }
}