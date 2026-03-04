<?php
namespace App\Http\Controllers\Api;
use App\Helpers\ResponseHelpers;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CatInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatRequest;


class CatController extends Controller
{
    protected $repository;

    public function __construct(CatInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $repo = $this->repository->allCategory();
        return ResponseHelpers::success($repo,'Data Category');
    }

    public function show($id)
    {
        return response()->json($this->repository->findCategory($id));
    }

    public function store(CatRequest $request)
    {
        $data = $request->all();
        $repo = $this->repository->createCategory($data);
        $resource = new CategoryResource($repo);
        return ResponseHelpers::success($resource,'Berhasil Membuat Category');
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
