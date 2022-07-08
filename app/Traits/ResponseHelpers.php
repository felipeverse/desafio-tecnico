<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseHelpers
{

    /**
     * Success json response helper
     *
     * @param $data
     * @param $message
     * @param $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($data, $message = '', $status = 200)
    {
        $request = request();

        return response()->json([
            'request' => $request->fullUrl(),
            'method'  => strtoupper($request->method()),
            'success' => true,
            'code'    => $status,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    /**
     * Success paginated json response helper
     *
     * @param $result
     * @param $paginationData
     * @param $message
     * @param $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponsePaginated($data, $paginationData, $message = '', $status = 200)
    {
        $request = request();

        $response = array_merge([
            'request' => $request->fullUrl(),
            'method'  => strtoupper($request->method()),
            'success' => true,
            'code'    => $status,
            'message' => $message,
            'data'    => $data
        ], $paginationData);

        return response()->json($response, $status);
    }


    /**
     * Error json response helper
     *
     * @param $message
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($message, array $data = [], $status = 500)
    {
        $request = request();

        return response()->json([
            'request' => $request->fullUrl(),
            'method'  => strtoupper($request->method()),
            'success' => false,
            'code'    => $status,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    /**
     * Only data json response helper
     *
     * @param  $data
     * @param  integer $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendData($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    // NOTE: Comentado por usar DefaultResponse, implementar depois
    /**
     * Helper para montar response de autenticação
     *
     * @param array $errors
     * @return JsonResponse
     */
    // public function unauthenticatedErrorResponse(array $errors): JsonResponse
    // {
    //     $defaultResponse = new DefaultResponse(
    //         null,
    //         false,
    //         $errors,
    //         401
    //     );

    //     return response()->json($defaultResponse->toArray(), $defaultResponse->code);
    // }
}
