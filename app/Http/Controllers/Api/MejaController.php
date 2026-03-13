<?php

namespace App\Http\Controllers\Api;

use App\Models\Meja;
use App\Http\Resources\MejaResource;
use App\Http\Requests\StoreMejaRequest;
use App\Http\Requests\UpdateMejaRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::latest()->get();

        return MejaResource::collection($meja);
    }

    public function store(StoreMejaRequest $request)
    {
        $meja = Meja::create([
            'status' => $request->status
        ]);

        // URL untuk QR
        $url = url('/menu/' . $meja->table_number);

        // nama file QR
        $fileName = 'qr_' . $meja->table_number . '.png';

        // generate QR
        $qr = QrCode::format('svg')
            ->size(300)
            ->generate($url);

        // simpan ke storage
        Storage::disk('public')->put('qrcodes/' . $fileName, $qr);

        // update database
        $meja->update([
            'qr_code' => 'qrcodes/' . $fileName
        ]);

        return new MejaResource($meja);
    }

    public function show(Meja $meja)
    {
        return new MejaResource($meja);
    }

    public function update(UpdateMejaRequest $request, Meja $meja)
    {
        $meja->update($request->validated());

        return new MejaResource($meja);
    }

    public function destroy(Meja $meja)
    {
        // hapus QR jika ada
        if ($meja->qr_code) {
            Storage::disk('public')->delete($meja->qr_code);
        }

        $meja->delete();

        return response()->json([
            'message' => 'Meja berhasil dihapus'
        ]);
    }
}