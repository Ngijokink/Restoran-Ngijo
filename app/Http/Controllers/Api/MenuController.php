<?php
namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
use App\Http\Resources\MenuResource;
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

    private function imageUrl(?string $imagePath): ?string
    {
        if (!$imagePath) return null;
        $base = rtrim(config('app.url'), '/');
        return "{$base}/storage/{$imagePath}";
    }

   public function index(Request $request){
        try {
            $perPage = $request->query('per_page', 2);
            $query = $this->repository->allMenu()->paginate($perPage);
            
            return ResponseHelpers::success($query, 'Data Berhasil di temukan', 200);
        } catch (\Exception $e) {
            return ResponseHelpers::error(null, 'Gagal mengambil data menu: ' . $e->getMessage(), 500);
        }
   }

public function show($id)
{
    try {
        $menu = $this->repository->findMenu($id);
        
        if (!$menu) {
            return ResponseHelpers::error(null, 'Menu tidak ditemukan', 404);
        }

        return ResponseHelpers::success(new MenuResource($menu), 'Data Menu', 200);
    } catch (\Exception $e) {
        return ResponseHelpers::error(null, 'Gagal mengambil detail menu: ' . $e->getMessage(), 500);
    }
}

    public function store(MenuRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = UploadHelper::uploadImage($request->file('image'));
            }

            $menu = $this->repository->createMenu($data);
            $menu->image_url = $this->imageUrl($menu->image);
            $resource = new MenuResource($menu);

            return ResponseHelpers::success($resource, 'Berhasil Membuat Menu', 201);

        } catch (\Exception $e) {
            return ResponseHelpers::error(null, 'Gagal Membuat Menu: ' . $e->getMessage(), 500);
        }
    }

    public function update(MenuRequest $request, $id)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = UploadHelper::uploadImage($request->file('image'));
            }

            $updated = $this->repository->updateMenu($id, $data);
            if (!$updated) {
                return ResponseHelpers::error(null, 'Menu tidak ditemukan', 404);
            }
            
            $updated->image_url = $this->imageUrl($updated->image);
            $resource = new MenuResource($updated);

            return ResponseHelpers::success($resource, 'Berhasil Mengupdate Menu', 200);

        } catch (\Exception $e) {
            return ResponseHelpers::error(null, 'Gagal Mengupdate Menu: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->repository->deleteMenu($id);
            if (!$deleted) {
                return ResponseHelpers::error(null, 'Menu tidak ditemukan', 404);
            }
            
            return ResponseHelpers::success($deleted, 'Berhasil Menghapus Menu', 200);
        } catch (\Exception $e) {
            return ResponseHelpers::error(null, 'Gagal Menghapus Menu: ' . $e->getMessage(), 500);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $file = $request->file('image');
            if (!$file) {
                return ResponseHelpers::error(null, 'No file uploaded', 400);
            }
            
            $path = $this->repository->UploadImage($file);
            return ResponseHelpers::success(['path' => $path], 'Berhasil upload image', 200);
        } catch (\Exception $e) {
            return ResponseHelpers::error(null, 'Gagal upload image: ' . $e->getMessage(), 500);
        }
    }

    public function search(Request $request){
        try {
            $keyword = $request->query('search');
            if (!$keyword) {
                return ResponseHelpers::error(null, 'Parameter search tidak boleh kosong', 400);
            }
            
            $search = $this->repository->search($keyword)->get();
            return ResponseHelpers::success(
                MenuResource::collection($search),
                'Berhasil Menemukan Data',
                200
            );
        } catch (\Throwable $e) {
            return ResponseHelpers::error(null, $e->getMessage(), 500);
        }
    }
}