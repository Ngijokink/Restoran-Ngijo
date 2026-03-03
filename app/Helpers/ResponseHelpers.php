<?php
namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ResponseHelpers{
    public static function success(mixed $data, String $message = 'Success', int $code = Response::HTTP_OK){
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