<?php
namespace App\Http\Traits;
trait GeneralTrait
{
    public function apiResponse($data = null,bool $status = true,$error = null,$statusCode = 200)
    {
        return response([

            "data" => $data,
            "status" => $status,
            "error" => $error,
            "statusCode" => $statusCode

        ],$statusCode);
    }
    public function requiredField($message)
    {
        return $this->apiResponse(null,false,$message,400);
    }
    public function notFoundResponse($message)
    {
        return $this->apiResponse(null,false,$message,404);
    }
    public function unAuthorizedResponse()
    {
        return $this->apiResponse(null,false,"Unauthorize",401);
    }
}
