<?php

namespace App\Utils;

use Exception;

class JwtCustom {


    public static function getPayloadFromToken($token)
    {
        if(empty($token)){
            throw new Exception('Please provide token');
        }

        $tokenParts = explode(".", $token); 
        
        if(count($tokenParts) != 3){
            throw new Exception('Invalid token');
        }

        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);

        $jwtHeader = json_decode($tokenHeader,true);

        if(empty($jwtHeader) || !is_array($jwtHeader)){
            throw new Exception("Token can't parse");
        }
        
        $jwtPayload = json_decode($tokenPayload,true);

        if(empty($jwtPayload) || !is_array($jwtPayload)){
            throw new Exception("Token can't parse");
        }

        return $jwtPayload;
    }
}