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

    public function index()
    {
        return ResponseHelpers::success($this->repository->allMenu(),'Data Menu');
    }

    public function show($id)
    {
        return ResponseHelpers::success($this->repository->findMenu($id),'Data Menu');
    }

   public function store(Request $request)
{
    $imagePath = UploadHelper::uploadImage($request->file('image'));

    $data = $request->all();
    $data['image'] = $imagePath;

    $menu = $this->repository->createMenu($data);
    $menu->image_url = $menu->image
        ? url('storage/'.$menu->image)
        : null;

    return ResponseHelpers::success($menu, 'Berhasil Membuat Menu');
}

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return ResponseHelpers::success($this->repository->updateMenu($id, $data),'Berhasil Mengupdate Menu');
    }

    public function destroy($id)
    {
        return ResponseHelpers::success($this->repository->deleteMenu($id),'Berhasil Menghapus Menu');
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
