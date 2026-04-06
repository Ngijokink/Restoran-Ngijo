<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CatInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatRequest;
use Illuminate\Http\Request;

class CatController extends Controller
{
    protected $repository;

    public function __construct(CatInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 2);
            $paginate = $this->repository->allCategory()->paginate($perPage);

            return ResponseHelpers::success($paginate, 'Data Category');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal mengambil data category : ' . $e->getMessage());

        }
    }

    public function show($id)
    {
        try {

            $repo = $this->repository->findCategory($id);

            return ResponseHelpers::success(
                new CategoryResource($repo),
                'Detail Category'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menampilkan category : ' . $e->getMessage());

        }
    }

    public function store(CatRequest $request)
    {
        try {

            $data = $request->validated();
            $repo = $this->repository->createCategory($data);

            return ResponseHelpers::success(
                new CategoryResource($repo),
                'Berhasil Membuat Category'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal membuat category : ' . $e->getMessage());

        }
    }

    public function update(CatRequest $request, $id)
    {
        try {

            $data = $request->validated();
            $repo = $this->repository->updateCategory($id, $data);

            return ResponseHelpers::success(
                new CategoryResource($repo),
                'Berhasil Mengupdate Category'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal update category : ' . $e->getMessage());

        }
    }

    public function destroy($id)
    {
        try {

            $repo = $this->repository->deleteCategory($id);

            return ResponseHelpers::success(
                new CategoryResource($repo),
                'Berhasil Menghapus Category'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menghapus category : ' . $e->getMessage());

        }
    }

    public function search(Request $request){
        try{
            $search = $request->query('search');
            $perPage = $request->query('per_page', 1);
            $query = $this->repository->search($search)->paginate($perPage);
            return ResponseHelpers::success($query,
                'Data berhasil di temukan', 
                200
            );
        } catch (\Throwable $e){
            return ResponseHelpers::error(null, $e->getMessage(), 404);
        }
    }
    public function sorting(Request $request){
        $sort = $request->query('sortBy', 'id_category');
        $sortDirect = $request->query('sortDirection', 'asc');

        $sorting = $this->repository->sorting($sort, $sortDirect);
        if($sortDirect === 'desc'){
            return ResponseHelpers::success($sorting, "Data berhasil diurutkan sesuai $sort dari yang terbesar ke terkecil", 200);
        }
        return ResponseHelpers::success($sorting, "Data berhasil diurutkan sesuai $sort dari yang terkecil ke terbesar", 200);
    }
}