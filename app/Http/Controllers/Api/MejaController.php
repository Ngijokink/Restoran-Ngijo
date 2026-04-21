<?php

namespace App\Http\Controllers\Api;

use App\Models\Meja;
use App\Http\Resources\MejaResource;
use App\Http\Requests\StoreMejaRequest;
use App\Http\Requests\UpdateMejaRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MejaController extends Controller
{
    public function index()
    {
        try {
            $meja = Meja::orderBy('id_table', 'desc')->get();
            return MejaResource::collection($meja);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data meja: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreMejaRequest $request)
{
    try {
        // 1. Simpan data meja (pastikan table_number unik agar file tidak tertumpu)
        $meja = Meja::create([
            'status' => $request->status,
            'table_number' => $request->table_number 
        ]);

        // 2. Tentukan nama file & Path
        // File akan masuk ke: storage/app/public/qrcodes/qr-1.svg
        $fileName = 'qr-' . $meja->table_number . '.svg';
        $path = 'qrcodes/' . $fileName;

        // 3. Generate QR Code
        $url = url('/menu/' . $meja->table_number);
        $qrCodeXml = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate($url);

        // 4. Simpan ke storage/app/public/qrcodes
        // Laravel otomatis membuat folder 'qrcodes' jika belum ada
        Storage::disk('public')->put($path, $qrCodeXml);

        // 5. Update kolom qr_code dengan path-nya saja
        $meja->update([
            'qr_code' => $path
        ]);

        return new MejaResource($meja);

    } catch (\Exception $e) {
        Log::error('Meja Store Error: ' . $e->getMessage());
        return response()->json([
            'message' => 'Gagal membuat meja: ' . $e->getMessage()
        ], 500);
    }
}

    public function show(Meja $meja)
    {
        try {
            return new MejaResource($meja);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil detail meja: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateMejaRequest $request, Meja $meja)
    {
        try {
            $meja->update($request->validated());
            return new MejaResource($meja);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate meja: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Meja $meja)
    {
        try {
            $meja->delete();

            return response()->json([
                'message' => 'Meja berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus meja: ' . $e->getMessage()
            ], 500);
        }
    }
}