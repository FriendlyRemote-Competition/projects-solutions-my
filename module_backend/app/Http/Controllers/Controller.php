<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function success200($data = [])
    {
        return response()->json([
            "data" => $data,
        ], 200);
    }
    public function success200Meta($data = [], $meta = [])
    {
        return response()->json([
            "data" => $data,
            "meta" => $meta,
        ]);
    }
    public function success201($data = [])
    {
        return response()->json([
            "data" => $data,
        ],201);
    }
    public function error401($message = "Unauthenticated")
    {
        return response()->json([
            "message" => $message
        ], 401);
    }

    public function error403($message = "Forbidden")
    {
        return response()->json([
            "message" => $message

        ],403);
    }

    public function error404($message = "Resource not found")
    {
        return response()->json([
            "message" => $message
        ],404);
    }

    public function error422Bis($message = "Unprocessable Entity")
    {
        return response()->json([
            "message" => $message
        ],422);
    }

    public function error422($message = "Validation failed", $errors = [])
    {
        return response()->json([
            "message" => $message,
            "errors" => $errors
        ],422);
    }
}
