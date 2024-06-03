<?php

namespace App\traits;

trait ResponseApi
{
    protected function jsonResponse($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        return json_encode($data);
    }

    protected function jsonSuccess($data = [], $statusCode = 200)
    {
        $response = [
            'data' => $data
        ];
        return $this->jsonResponse($response, $statusCode);
    }

    protected function jsonError($message, $data = [], $statusCode = 400)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ];
        return $this->jsonResponse($response, $statusCode);
    }
}

