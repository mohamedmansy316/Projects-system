<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;

class BaseController extends Controller{
    /**
     * return response when the process is success
     *
     * @return \Illuminate\Http\Response with data , response message and status code
     */
    public function sendResponse($result, $message, $code = 200){
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }

    /**
     * Return response when there is an error
     *
     * @return \Illuminate\Http\Response with data, response message and status code
     */
    public function sendError($error, $errorMessages = [], $code = 404){
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
