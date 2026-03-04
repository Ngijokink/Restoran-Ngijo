<?php
namespace App\Http\Controllers\Api;
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
        return response()->json($this->repository->allMenu());
    }

    public function show($id)
    {
        return response()->json($this->repository->findMenu($id));
    }

    public function store(Request $request)
    {
         $imagePath = UploadHelper::uploadImage($request->file('image'));

        $data = $request->all();
        $data['image'] = $imagePath;
        return response()->json($this->repository->createMenu($data));
        

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->repository->updateMenu($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteMenu($id));
    }
    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        if ($file) {
            $path = $this->repository->UploadImage($file);
            return response()->json(['path' => $path]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
