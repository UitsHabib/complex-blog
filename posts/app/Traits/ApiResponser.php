<?php

namespace App\Traits;

trait ApiResponser
{
    protected function successResponse($data, $message = '', $code = 200) : \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status_code'    => $code,
            'status'        => 'Success',
            'message'       => $message,
            'data'          => $data,
        ],
        $code, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    protected function errorResponse($message, $code) : \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status_code'    => $code > 511 ? 500 : $code,
            'status'        => 'Error',
            'message'       => !env('APP_DEBUG') && $code > 499 ? 'Internal Server Error' : $message,
            'data'          => null,
        ],
        $code, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

}
