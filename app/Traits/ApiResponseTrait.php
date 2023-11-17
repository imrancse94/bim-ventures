<?php

namespace App\Traits;

trait ApiResponseTrait{


    public function sendResponse($data, $message, $code, $http_code = 200)
    {
        
        $response['code'] = $code;

        if(!empty($message)){
            $response['message'] = $message;
        }
        
        if(!empty($data)){
            $response['data'] = $data;
        }
       
        return response()->json($response, $http_code);
    }

}