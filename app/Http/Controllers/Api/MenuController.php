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

    public function index()
{
    $menus = $this->repository->allMenu();
    // $resource = MenuResource::collection($menus);
    
    // Gunakan Resource Collection agar relasi 'kategori' ikut terformat
    return ResponseHelpers::success($menus, 'Data Menu');
}

public function show($id)
{
    $menu = $this->repository->findMenu($id);
    
    if (!$menu) {
        return ResponseHelpers::error(null, 'Menu tidak ditemukan', 404);
    }

    // Bungkus dengan MenuResource
    return ResponseHelpers::success(new MenuResource($menu), 'Data Menu');
}

    public function store(MenuRequest $request)
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('image')) {
                $data['image'] = UploadHelper::uploadImage($request->file('image')); // ✅ Hapus duplikat, taruh di dalam try
            }

            $menu = $this->repository->createMenu($data);
            $menu->image_url = $this->imageUrl($menu->image);
            $resource = new MenuResource($menu);

            return ResponseHelpers::success($resource, 'Berhasil Membuat Menu');

        } catch (\Exception $e) {
            return ResponseHelpers::error(null, 'Gagal Membuat Menu: ' . $e->getMessage());
        }
        // ✅ Dead code dihapus
    }

    public function update(MenuRequest $request, $id) // ✅ Ganti Request → MenuRequest
    {
        $data = $request->validated(); // ✅ Ganti all() → validated()

        try {
            if ($request->hasFile('image')) {
                $data['image'] = UploadHelper::uploadImage($request->file('image')); // ✅ Tambah handle image
            }

            $updated = $this->repository->updateMenu($id, $data);
            if ($updated) {
                $updated->image_url = $this->imageUrl($updated->image);
            }

            return ResponseHelpers::success($updated, 'Berhasil Mengupdate Menu');

        } catch (\Exception $e) {
            return ResponseHelpers::error(null, 'Gagal Mengupdate Menu: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        return ResponseHelpers::success(
            $this->repository->deleteMenu($id),
            'Berhasil Menghapus Menu'
        );
    }

    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        if ($file) {
            $path = $this->repository->UploadImage($file);
            return response()->json(['path' => $path]);
        }
        return ResponseHelpers::error(null, 'No file uploaded', 400);
    }
}