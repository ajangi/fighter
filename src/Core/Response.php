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

    public function send()
    {
        http_response_code($this->status_code);
        header('content-type:application/json');
        echo json_encode($this->body);
        return;
    }
}