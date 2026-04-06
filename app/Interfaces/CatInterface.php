<?php
namespace App\Interfaces;

interface CatInterface
{
    public function allCategory();
    public function findCategory($id);
    public function createCategory(array $data);
    public function updateCategory($id, array $data);
    public function deleteCategory($id);
    public function search($keyword);
    public function sorting($sortBy = 'Id', $sortDirection = 'asc');
}