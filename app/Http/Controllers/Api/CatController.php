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
        try {

            $repo = $this->repository->allCategory();

            return ResponseHelpers::success(
                CategoryResource::collection($repo),
                'Data Category'
            );

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
}