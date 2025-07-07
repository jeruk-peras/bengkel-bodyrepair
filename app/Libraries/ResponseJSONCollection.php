<?php

namespace App\Libraries;

class ResponseJSONCollection
{
    protected static $response = [
        'status' => 200,
        'message' => 'Success',
        'data' => null,
    ];

    public static function success($data = null, $message = 'Success', $status = 200)
    {
        self::$response['status'] = $status;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        
        return response()->setStatusCode($status)->setJSON(self::$response);
    }
    
    public static function error($data = null, $message = 'Error', $status = 400)
    {
        self::$response['status'] = $status;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        
        return response()->setStatusCode($status)->setJSON(self::$response);
    }




}
