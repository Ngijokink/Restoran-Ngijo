<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Interfaces\CrudMenusInterface;


    class MenusController extends Controller
    {
        protected $repository;
    public function __construct(CrudMenusInterface $repository)
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
        $data = $request->all();
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
}
