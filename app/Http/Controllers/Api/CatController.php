<?php
namespace App\Http\Controllers\Api;
use App\Interfaces\CatInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requests\CatRequest;


class CatController extends Controller
{
    protected $repository;

    public function __construct(CatInterface $repository)
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

    public function store(CatRequest $request)
    {
        $data = $request->all();
        return response()->json($this->repository->createCategory($data));
    }

    public function update(CatRequest $request, $id)
    {
        $data = $request->all();
        return response()->json($this->repository->updateCategory($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteCategory($id));
    }
}
