<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LoginService;
use App\Supports\ResponseValidation;
use App\Validations\Auth\LoginValidation;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private LoginService $login_service;

    public function __construct()
    {
        $this->login_service = new LoginService;
    }

    /**
     * View page login
     * 
     */
    public function index()
    {
        return \view("auth.login");
    }

    /**
     * Store login
     * 
     * @param Request $request
     */
    public function store(Request $request)
    {
        LoginValidation::check();
        if (LoginValidation::fails()) {
            return ResponseValidation::response(LoginValidation::errors());
        }

        $response = $this->login_service->login($request);
        return \response_json($response);
    }
}
