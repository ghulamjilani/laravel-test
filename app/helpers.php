<?php

if (!function_exists('makeResponse')) {
    function makeResponse($code, $message = '', $data = [], $status = 500, $error = [])
    {
        return response()->json([
            'code'      => $code, 
            'message'   => $message, 
            'data'      => $data,
            'errors'    => $error,
        ], $status);
    }
}