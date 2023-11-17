<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Utils\ApplicationStatus;
use App\Utils\JwtCustom;



class AuthController extends Controller
{
    private $auth = null;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->only(['email', 'password']);//request(['email', 'password']);
        
        $user = (new User())->getUserByCredential(
                        $credentials['email'],
                        $credentials['password']
                );
        
        if(empty($user)){
            return $this->sendResponse([],'No data found',ApplicationStatus::FAILED);
        }        
       
        if (! $token = auth()->claims(['user_id' => $user['id']])->login($user)) {
            return $this->sendResponse([],'No data found',ApplicationStatus::FAILED); //response()->json(['error' => 'Unauthorized'], 200);
        }
        
        $this->auth = $user;

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authInfo()
    {
        return $this->respondWithToken(request()->bearerToken());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        
        $user = $this->auth;
        
        if(empty($user) && !empty($token)){
            
            $payload = JwtCustom::getPayloadFromToken($token);//$this->decodeToken($token);

            if(!empty($payload['user_id'])){
                $user = (new User())->findById($payload['user_id']);
            }
        }
        
        $data = [
            'user'=> $user,
            'access_token' => $token,
           // 'refresh_token'=> auth('api')->refresh(),
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ];
        
        return $this->sendResponse($data,'Sucessfully generated token',ApplicationStatus::SUCCESS);
    }


    private function decodeToken($token){

        $tokenParts = explode(".", $token); 
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader,true);
        $jwtPayload = json_decode($tokenPayload,true);

        return $jwtPayload;
    }
}
