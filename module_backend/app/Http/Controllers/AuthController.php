<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if(Auth::guard("web")->attempt(["email" => $data["email"], "password" => $data["password"]])){
            $user = Auth::guard("web")->user();

            if(!$user->is_active)return $this->error401("Invalid credentials");

            $token = Str::random(60);
            $user->token = $token;
            $user->save();

            return $this->success200([
                "token" => $token,
                "user" => $user->only("email", "name", "role"),
            ]);
        }
    }
}
