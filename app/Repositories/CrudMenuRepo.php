<?php
namespace App\Repositories;
use App\Models\Menu;
use App\Interfaces\CrudMenusInterface;
use Illuminate\Database\Eloquent\Model;

class CrudMenuRepo implements CrudMenusInterface
{
    protected $model;

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function allMenu()
    {
        return $this->model->all();
    }

    public function findMenu($id)
    {
        return $this->model->find($id);
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
}