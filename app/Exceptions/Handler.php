<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use App\Utils\ApplicationStatus;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        
        $this->reportable(function (Throwable $e) {

            $this->renderable(function(MethodNotAllowedException $e, $request){
                return $this->sendResponse([],'Method is not allowed',ApplicationStatus::TOKEN_INVALID);
            });
           
            $this->renderable(function(TokenInvalidException $e, $request){
                return $this->sendResponse([],'Invalid token',ApplicationStatus::TOKEN_INVALID);
            });
    
            $this->renderable(function (TokenExpiredException $e, $request) {
                return $this->sendResponse([],'Token has Expired',ApplicationStatus::TOKEN_EXPIRED);
            });
    
            $this->renderable(function (JWTException $e, $request) {
                return $this->sendResponse([],'Token not parsed',ApplicationStatus::TOKEN_NOT_PARSED);
            });

            $this->renderable(function(UnauthorizedHttpException $e, $request){
                return $this->sendResponse([],'Unathenticated',ApplicationStatus::TOKEN_INVALID);
            });
        });

    }


    public function render($request,Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->sendResponse([],'Method is not allowed',ApplicationStatus::METHOD_NOT_ALLOWED);
        }

        return parent::render($request, $e);
    }

    
}
