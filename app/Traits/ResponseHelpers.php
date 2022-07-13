<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseHelpers
{
    /**
     * Success json response helper
     *
     * @param mixed $data
     * @param string $message
     * @param integer $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($data, $message = '', $status = 200)
    {
        $request = request();

        return response()->json(
            [
                'request' => $request->fullUrl(),
                'method'  => strtoupper($request->method()),
                'success' => true,
                'code'    => $status,
                'message' => $message,
                'data'    => $data,
            ],
            $status
        );
    }

    /**
     * Success paginated json response helper
     *
     * @param mixed $data
     * @param mixed $paginationData
     * @param string $message
     * @param integer $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponsePaginated($data, $paginationData, $message = '', $status = 200)
    {
        $request = request();

        $response = array_merge(
            [
                'request' => $request->fullUrl(),
                'method'  => strtoupper($request->method()),
                'success' => true,
                'code'    => $status,
                'message' => $message,
                'data'    => $data
            ],
            $paginationData
        );
        return response()->json($response, $status);
    }

    /**
     * Error json response helper
     *
     * @param mixed $message
     * @param array $data
     * @param integer $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($message, array $data = [], $status = 500)
    {
        $request = request();

        return response()->json(
            [
                'request' => $request->fullUrl(),
                'method'  => strtoupper($request->method()),
                'success' => false,
                'code'    => $status,
                'message' => $message,
                'data'    => $data,
            ],
            $status
        );
    }

    /**
     * Only data json response helper
     *
     * @param mixed $data
     * @param integer $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendData($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
