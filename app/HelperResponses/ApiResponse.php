<?php

namespace App\HelperResponses;

use Illuminate\Http\JsonResponse;
use stdClass;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiResponse
{



    protected static $response = [
        "body" => [
            'code' => "00",
            'info' => 'success',
            'data' => null
        ],
        "status" => 200
    ];

    public static function success($data = null, $info = null, $code = 202)
    {
        self::$response['body']['info'] = $info;
        self::$response['body']['data'] = $data;
        self::$response['body']['code'] = $code;

        return response()->json(self::$response['body'], self::$response['status']);
    }

    public static function errorWithStatus($data = null, $info = null, $status = 400, $code = "-1")
    {

        self::$response["body"]['code'] = $code;
        self::$response["body"]['info'] = $info;
        self::$response["body"]['data'] = $data;

        self::$response['status'] = $status;

        return response()->json(self::$response["body"], self::$response["status"]);
    }

    public static function error($e = null, $code = "-1", $info = "server sedang error,silakan coba lagi")
    {
        if ($e instanceof HttpException) {
            self::$response["body"]['info'] = $e->getMessage();
            self::$response['status'] = $e->getStatusCode();
        } else {
            self::$response["body"]['info'] = $info;
            self::$response['status'] = 500;
        }

        self::$response["body"]['code'] = $code;
        self::$response["body"]['data'] = new stdClass();

        return response()->json(self::$response["body"], self::$response["status"]);
    }
}
