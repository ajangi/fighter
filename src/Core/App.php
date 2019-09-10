<?php

namespace Fighter\Core;
use Fighter\Router\Router;

class App {
    public $request;
    public $response;
    public $router;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response(200,[],[]);
        $this->router = new Router();
    }

    public function handleRequest()
    {
        return $this->router->handle($this->request);
    }
    public function send()
    {
        $this->response->send();
    }
}