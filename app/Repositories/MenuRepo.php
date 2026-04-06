<?php
namespace App\Repositories;
use App\Models\Menu;
use App\Interfaces\MenusInterface;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\UploadHelper;

class MenuRepo implements MenusInterface
{
    protected $model;

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    // MenuRepo.php

public function allMenu()
{
    // Mengambil semua menu beserta datanya di table_categories
    return $this->model->with('category');
}

public function findMenu($id)
{
    // Mengambil satu menu beserta kategorinya
    return $this->model->with('category')->find($id);
}

    public function createMenu(array $data)
    {
        return $this->model->create($data);
    }

    public function updateMenu($id, array $data)
    {
        $record = $this->model->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function deleteMenu($id)
    {
        $record = $this->model->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
    public function UploadImage($file)
    {
        return UploadHelper::uploadImage($file, 'menus');
    }

    public function search($keyword){
        return $this->model->with('category')
                            ->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhere('price','LIKE',"%{$keyword}%")
                            ->orWhere('stock','LIKE',"%{$keyword}%")
                            ->orWhere('is_available','LIKE',"%{$keyword}%");
    }
}