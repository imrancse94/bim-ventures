<?php

namespace App\Utils;

class ApplicationStatus {

    const SUCCESS = 100;
    const FAILED = 400;

    const TOKEN_EXPIRED = 402;
    const TOKEN_INVALID = 401;
    const TOKEN_NOT_PARSED = 403;
    const METHOD_NOT_ALLOWED = 405;
}