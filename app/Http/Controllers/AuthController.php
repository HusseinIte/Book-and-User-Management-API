<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Service\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService=$authService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request){
        try{
            $credentials=$request->validated();
            $success= $this->authService->login($credentials);
            return $this->sendRespons($success, 'User login successfully.');

        }catch(AuthenticationException $e){
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function profile(){
        $success=$this->authService->profile();
        return $this->sendRespons($success, 'Refresh token return successfully.');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        $this->authService->logout();
        return $this->sendRespons([], 'Successfully logged out.');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function refresh(){
        $success=$this->authService->refresh();
        return $this->sendRespons($success, 'Refresh token return successfully.');

    }
}
