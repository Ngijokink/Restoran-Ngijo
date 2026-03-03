<?php
namespace App\Interfaces;

interface AuthInterface{
    public function create($data);
    public function findEmail($email);
}
//interfaces 