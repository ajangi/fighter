<?php


namespace Fighter\Router;


use Fighter\Core\Request;

class Router
{
    public $request;
    public static $routes = [];
    public function __construct()
    {
        $this->request  = new Request();
    }
    public static function group($prefix,$routes)
    {
        foreach ($routes as $route){
            self::$routes[] = [
                'uri' => $prefix.$route['uri'],
                'method' => $route['method'],
                'controller' => $route['controller'],
                'action' => $route['action']
            ];
        }
    }
    public static function add($routes)
    {
        if (is_array($routes)){
            if (array_key_exists('method',$routes)){
                self::$routes[] = [
                    'uri' => $routes['uri'],
                    'method' => $routes['method'],
                    'controller' => $routes['controller'],
                    'action' => $routes['action']
                ];
            }else{
                foreach ($routes as $route){
                    self::$routes[] = [
                        'uri' => $route['uri'],
                        'method' => $route['method'],
                        'controller' => $route['controller'],
                        'action' => $route['action']
                    ];
                }
            }
        }else{
            // TODO : Return error and say give me an array
        }
    }
    private function findRoute(){
        $method = $this->request->method;
        $uri = $this->request->uri;
        foreach (self::$routes as $route){
            if ($route['method'] === $method && $route['uri'] === $uri){
                return $route;
                break;
            }
        }
        return null;
    }
    public function handle(Request $request){
        $route = $this->findRoute();
        var_dump($route);
        return 0;
        if (is_callable($action)){
            $exploded = func_get_args()[1];
            return call_user_func($action,$exploded);
        }else{
            $exploded = explode('@',$action);
            $controllerString = 'Fighter\\Controllers\\'.$exploded[0];
            if (class_exists($controllerString)){
                $handler = $exploded[1];
                $controller = new $controllerString($this->request);
                return $controller->$handler();
            }else{
                return new \Exception("ERROR FINDING CONTROLLER!!");
            }
        }
    }
}