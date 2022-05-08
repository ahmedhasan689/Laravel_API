<?php

namespace App\Trait;

use Illuminate\Support\Facades\Response;

trait PostTrait
{
    public function response($data = null, $status = null,$message = null)
    {
        $response = [
            'data' => $data,
            'status' => $status,
            'message' => $message,
        ];

        return Response::json($response);
    }
}
