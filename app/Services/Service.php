<?php

namespace App\Services;


abstract class Service
{

    public $response_code = "000";
    
    public $message = "Something wrong!";

    public $data = [];
}
