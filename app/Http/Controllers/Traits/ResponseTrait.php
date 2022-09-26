<?php

namespace App\Http\Controllers\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    public function response($isSuccess, $statusCode, $message, $data)
    {
        return response()->json([
            "success" => $isSuccess,
            "statusCode" => $statusCode,
            "mesage" => $message,
            "data" => $data,
        ], $statusCode);
    }

    // internal server error fail response
    public function internalServerFailResponse(){
        return $this->response(false, Response::HTTP_INTERNAL_SERVER_ERROR, "Internal Server Error", null);
    }

    // bad request fail response
    public function badRequestFailResponse($validator)
    {
        return $this->response(false, Response::HTTP_BAD_REQUEST, "Bad Request", ["details" => $validator ?? ""]);
    }

    // not found fail response
    public function notFoundFailResponse()
    {
        return $this->response(false, Response::HTTP_NOT_FOUND, "Particular resource does not exists", null);
    }

    // success response
    public function successResponse($message, $data){
        return $this->response(true, Response::HTTP_OK, $message, $data);
    }
}