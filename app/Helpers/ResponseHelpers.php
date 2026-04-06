<?php
namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelpers{
    public static function success(mixed $data, String $message = 'Success', int $code = Response::HTTP_OK){
        
        // CEK kalau data pagination
        if ($data instanceof LengthAwarePaginator || $data instanceof Paginator) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data->items(), // isi data
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => method_exists($data, 'lastPage') ? $data->lastPage() : null,
                    'per_page' => $data->perPage(),
                    'total' => method_exists($data, 'total') ? $data->total() : null,
                ]
            ], $code);
        }

        // kalau bukan pagination
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($data = null, String $message = 'Error', int $code = Response::HTTP_BAD_REQUEST){
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}