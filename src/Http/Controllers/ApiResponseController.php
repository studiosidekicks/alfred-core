<?php

namespace Studiosidekicks\Alfred\Http\Controllers;

use \Illuminate\Routing\Controller;

class ApiResponseController extends Controller
{
    public function response($response, $error = false, $code = 400)
    {
        if (is_string($response)) {
            $response = ['message' => $response];
        }

        if ($error) {
            return $this->error($response, $code);
        }

        return $this->success($response);
    }

    private function error($data, $code)
    {
        return response()->json($data, $code);
    }

    private function success($data)
    {
        return response()->json($data);
    }
}