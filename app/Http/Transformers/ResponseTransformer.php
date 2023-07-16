<?php

namespace App\Http\Transformers;

use Illuminate\Http\JsonResponse;

class ResponseTransformer
{
    protected $data, $message, $code, $headers;

    public function __construct($data = null, $message = 'Ok', $code = 200, $headers = [])
    {
        $this->data = $data;
        $this->message = $message;
        $this->code = $code;
        $this->headers = $headers;
    }

    public function format()
    {
        $response = [
            'status' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ];
        return $response;
    }

    public function toJson()
    {

        return new JsonResponse($this->format(), $this->code, $this->headers);
    }
}
