<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
use Illuminate\Http\Request;
use App\Interfaces\MenusInterface;
use App\Http\Controllers\Controller;
use App\Helpers\UploadHelper;
use App\Http\Requests\MenuRequest;


class MenuController extends Controller
{
    protected $repository;

    public function __construct(MenusInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try {

            $menus = $this->repository->allMenu();

            return ResponseHelpers::success($menus,'Data menu');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null,$e->getMessage());

        }
    }

    public function show($id)
    {
        try {

            $menu = $this->repository->findMenu($id);

            if (!$menu) {
                return ResponseHelpers::error(null,'Menu tidak ditemukan');
            }

            return ResponseHelpers::success($menu,'Detail menu');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null,$e->getMessage());

        }
    }

    public function store(MenuRequest $request)
    {
        try {

            $data = $request->validated();

            if ($request->hasFile('image')) {

                $data['image'] = UploadHelper::uploadImage(
                    $request->file('image')
                );

            }

            $menu = $this->repository->createMenu($data);

            return ResponseHelpers::success($menu,'Menu berhasil dibuat');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null,$e->getMessage());

        }
    }

    public function update(MenuRequest $request, $id)
    {
        try {

            $data = $request->validated();

            if ($request->hasFile('image')) {

                $data['image'] = UploadHelper::uploadImage(
                    $request->file('image')
                );

            }

            $menu = $this->repository->updateMenu($id,$data);

            return ResponseHelpers::success($menu,'Menu berhasil diupdate');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null,$e->getMessage());

        }
    }

    public function destroy($id)
    {
        try {

            $this->repository->deleteMenu($id);

            return ResponseHelpers::success(null,'Menu berhasil dihapus');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null,$e->getMessage());

        }
    }
}