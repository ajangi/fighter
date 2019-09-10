<?php

namespace Fighter\Core;


class Request
{
    
    public $server;
    private $raw_get;
    private $raw_post;
    public $get;
    public $post;
    public $method;
    public $uri;
    public $uriParamsLength;
    public function __construct()
    {
        $this->server = $_SERVER;
        $this->raw_get = $_GET;
        $this->raw_post = $_POST;
        $this->method = $this->getRequestMethod();
        $this->get = $this->raw_get;
        $this->post = $this->raw_post;
        $this->uri = $this->getUri();
        $this->uriParamsLength = $this->getUriParamsLength();
    }

    private function getRequestMethod(){
        return $this->server['REQUEST_METHOD'];
    }

    private function getUri(){
        $uri = $this->getRawUri();
        if (substr($uri,-1) === "/"){
            return $uri;
        }else{
            return $uri."/";
        }
    }
    private function getRawUri(){
        $uri = $this->server['REQUEST_URI'];
        $uri = explode('?',$uri)[0];
        return $uri;
    }
    private function getUriParamsLength(){
        $uri = $this->getUri();
        $params = explode('/',$uri);
        return count($params);
    }
}