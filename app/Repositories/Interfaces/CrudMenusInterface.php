<?php
namespace App\Repositories\Interfaces;

interface CrudMenusInterface
{
    public function allMenu();
    public function findMenu($id);
    public function createMenu(array $data);
    public function updateMenu($id, array $data);
    public function deleteMenu($id);
}