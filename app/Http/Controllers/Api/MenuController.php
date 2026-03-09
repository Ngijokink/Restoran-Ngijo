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

    /**
     * Buat image_url pakai APP_URL dari config,
     * bukan dari request host — supaya ngrok URL yang keluar.
     */
    private function imageUrl(?string $imagePath): ?string
    {
        if (!$imagePath) return null;
        $base = rtrim(config('app.url'), '/');
        return "{$base}/storage/{$imagePath}";
    }

    public function index()
    {
        $menus = $this->repository->allMenu();

        foreach ($menus as $menu) {
            $menu->image_url = $this->imageUrl($menu->image);
        }

        return ResponseHelpers::success($menus, 'Data Menu');
    }

    public function show($id)
    {
        $menu = $this->repository->findMenu($id);
        $menu->image_url = $this->imageUrl($menu->image);

        return ResponseHelpers::success($menu, 'Data Menu');
    }

    public function store(Request $request)
    {
        $imagePath = UploadHelper::uploadImage($request->file('image'));

        $data = $request->all();
        $data['image'] = $imagePath;

        $menu = $this->repository->createMenu($data);
        $menu->image_url = $this->imageUrl($menu->image);

        return ResponseHelpers::success($menu, 'Berhasil Membuat Menu');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $updated = $this->repository->updateMenu($id, $data);
        if ($updated) {
            $updated->image_url = $this->imageUrl($updated->image);
        }
        return ResponseHelpers::success($updated, 'Berhasil Mengupdate Menu');
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