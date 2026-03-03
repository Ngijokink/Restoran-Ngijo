<?php
namespace App\Http\Controllers;
use App\Repositories\Interfaces\CrudCatInterface;
use Illuminate\Http\Request;
use App\Requests\CrudCatRequest;


class CrudCatController extends Controller
{
    protected $repository;

    public function __construct(CrudCatInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->allCategory());
    }

    public function show($id)
    {
        return response()->json($this->repository->findCategory($id));
    }

    public function store(CrudCatRequest $request)
    {
        $data = $request->all();
        return response()->json($this->repository->createCategory($data));
    }

    public function update(CrudCatRequest $request, $id)
    {
        $data = $request->all();
        return response()->json($this->repository->updateCategory($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteCategory($id));
    }
}
