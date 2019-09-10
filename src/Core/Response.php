<?php


namespace Fighter\Core;


class Response
{
    private $status_code = 200;
    private $headers = [];
    private $body;

    public function __construct($status_code, $body, $headers)
    {
        $this->body = $body;
        $this->status_code = $status_code;
        $this->headers = $headers;
    }

    public static function MethodNotAllowed(Request $request)
    {
        http_response_code(405);
        header('content-type:application/json');
        $response = [
            'status_code' => 405,
            'result'=>'ERROR',
            'messages' => ['method '. $request->method . ' not allowed for request '],
            'data'=>null
        ];
        echo json_encode($response);
        return '';
    }
    public static function NotFound()
    {
        http_response_code(404);
        header('content-type:application/json');
        $response = [
            'status_code' => 404,
            'result'=>'ERROR',
            'messages' => ['Not Found!'],
            'data'=>null
        ];
        echo json_encode($response);
        return '';
    }

    public function send()
    {
        http_response_code($this->status_code);
        header('content-type:application/json');
        echo json_encode($this->body);
        return;
    }
}