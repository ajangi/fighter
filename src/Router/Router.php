<?php


namespace Fighter\Router;


use Fighter\Core\Request;
use Fighter\Core\Response;

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
        $routes = $this->handleRouteMatch();
        if (count($routes) === 0){
            return Response::NotFound();
        }else{
            foreach ($routes as $route){
                if ($route['method'] === $method){
                    return $route;
                    break;
                }
            }
            return Response::MethodNotAllowed($this->request);
        }
    }

    private function handleRouteMatch(){
        $num = $this->request->uriParamsLength;
        $Routes = array_filter(self::$routes,function ($uri) use($num){
            $array = explode('/',$uri['uri']);
            if (count($array) === $num)
                return true;
            return false;
        });
        $Route = array_filter($Routes,function ($uri){
            $inputUri = $this->request->uri;
            $inputArray = explode('/',$inputUri);
            $array = explode('/',$uri['uri']);
            foreach ($inputArray as $key=>$item){
                if (strpos($array[$key],":") === false){
                    if ($item !== $array[$key]){
                        return false;
                    }
                }
            }
            return true;
        });
        return $Route;
    }

    private function getUriParams($matchUri){
        $matchUri = explode('/',$matchUri['uri']);
        $matchUri = array_filter($matchUri,function ($item){
            if (strpos($item,":") === 0 ){
                return true;
            }
            return false;
        });
        return $matchUri;
    }

    public function handle(Request $request){
        $matchRoute =  $this->findRoute();
        $uriParams = $this->getUriParams($matchRoute);
        $controllerString = 'Fighter\\Controllers\\'.$matchRoute['controller'];
        $handler = $matchRoute['action'];
        if (count($uriParams) > 0){
            $mainParams = [];
            $inputUriParams = explode('/',$this->request->uri);
            foreach ($uriParams as $key=>$param){
                $val = $inputUriParams[$key];
                $mainKey = ltrim($param, ':');
                $mainParams[$mainKey] = $val;
            }
            if (class_exists($controllerString)){
                $controller = new $controllerString($this->request);
                if (method_exists($controller,$handler)){
                    return call_user_func_array(array($controller, $handler), $mainParams);
                }else{
                    return new \Exception("ERROR FINDING Method!!");
                }
            }else{
                return new \Exception("ERROR FINDING CONTROLLER!!");
            }
        }else{
            if (class_exists($controllerString)){
                $controller = new $controllerString($this->request);
                if (method_exists($controller,$handler)){
                    return $controller->$handler();
                }else{
                    return new \Exception("ERROR FINDING Method!!");
                }
            }else{
                return new \Exception("ERROR FINDING CONTROLLER!!");
            }
        }
        //var_dump($matchRoute);
        /*if (is_callable($action)){
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
        }*/
    }
}