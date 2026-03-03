<?php
namespace App\Interfaces;

interface CrudCatInterface
{
    public function allCategory();
    public function findCategory($id);
    public function createCategory(array $data);
    public function updateCategory($id, array $data);
    public function deleteCategory($id);
}