<?php
namespace App\Repositories;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CatInterface;

class CatRepo implements CatInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function allCategory()
    {
        return $this->model->all();
    }

    public function findCategory($id)
    {
        return $this->model->find($id);
    }

    public function createCategory(array $data)
    {
        return $this->model->create($data);
    }

    public function updateCategory($id, array $data)
    {
        $record = $this->model->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function deleteCategory($id)
    {
        $record = $this->model->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
}
