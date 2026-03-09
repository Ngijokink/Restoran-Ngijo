<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
use Illuminate\Http\Request;
use App\Interfaces\MenusInterface;
use App\Http\Controllers\Controller;
use App\Helpers\UploadHelper;

class MenuController extends Controller
{
    protected $repository;

    public function __construct(MenusInterface $repository)
    {
        $this->repository = $repository;
    }

    private function imageUrl(?string $imagePath): ?string
    {
        if (!$imagePath) return null;

        $base = rtrim(config('app.url'), '/');
        return "{$base}/storage/{$imagePath}";
    }

    public function index()
    {
        try {

            $menus = $this->repository->allMenu();

            foreach ($menus as $menu) {
                $menu->image_url = $this->imageUrl($menu->image);
            }

            return ResponseHelpers::success($menus, 'Data Menu');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal mengambil menu : '.$e->getMessage());

        }
    }

    public function show($id)
    {
        try {

            $menu = $this->repository->findMenu($id);

            if ($menu) {
                $menu->image_url = $this->imageUrl($menu->image);
            }

            return ResponseHelpers::success($menu, 'Detail Menu');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menampilkan menu : '.$e->getMessage());

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            if ($request->hasFile('image')) {
                $imagePath = UploadHelper::uploadImage($request->file('image'));
                $data['image'] = $imagePath;
            }

            $menu = $this->repository->createMenu($data);

            if ($menu) {
                $menu->image_url = $this->imageUrl($menu->image);
            }

            return ResponseHelpers::success($menu, 'Berhasil Membuat Menu');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal membuat menu : '.$e->getMessage());

        }
    }

    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();

            if ($request->hasFile('image')) {
                $imagePath = UploadHelper::uploadImage($request->file('image'));
                $data['image'] = $imagePath;
            }

            $updated = $this->repository->updateMenu($id, $data);

            if ($updated) {
                $updated->image_url = $this->imageUrl($updated->image);
            }

            return ResponseHelpers::success($updated, 'Berhasil Mengupdate Menu');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal update menu : '.$e->getMessage());

        }
    }

    public function destroy($id)
    {
        try {

            $menu = $this->repository->deleteMenu($id);

            return ResponseHelpers::success($menu, 'Berhasil Menghapus Menu');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menghapus menu : '.$e->getMessage());

        }
    }

    public function uploadImage(Request $request)
    {
        try {

            if ($request->hasFile('image')) {

                $path = UploadHelper::uploadImage($request->file('image'));

                return ResponseHelpers::success(
                    ['path' => $path],
                    'Upload image berhasil'
                );

            }

            return ResponseHelpers::error(null, 'No file uploaded', 400);

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Upload gagal : '.$e->getMessage());

        }
    }
}