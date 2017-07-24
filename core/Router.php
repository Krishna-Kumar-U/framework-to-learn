<?php

namespace App\Core;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request AS Requests;
use App\Core\Request;

class Router
{
    /**
     * All registered routes.
     *
     * @var array
     */
    public $routes;

    public $request;

    public function __construct()
    {
       $this->routes = new RouteCollection();
    }

    protected function addToRouteCollection($uri, $route, $method )
    { 
        $this->routes->add($uri, $route, [],  [], '', [], [], 'context.getMethod() in '.$method);
    }

    /**
     * Load a user's routes file.
     *
     * @param string $file
     */
    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function get($uri, $controller)
    {
       // $this->routes['GET'][$uri] = $controller;
        $route = new Route(
                        $uri, 
                        ['_controller' => $controller]
                     );
        $route->setMethods(['GET']);
        //$this->addToRouteCollection( $uri, $route, "['GET']");
        $this->routes->add($uri.'-GET', $route, ['GET'],  [], '', [], [],  ["GET", "HEAD"]);
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function post($uri, $controller)
    {
        //$this->routes['POST'][$uri] = $controller;
        $route = new Route(
                        $uri, 
                        ['_controller' => $controller]
                     );
        $route->setMethods(['POST']);
        //$this->addToRouteCollection( $uri, $route, "['POST']");
        $this->routes->add($uri.'-POST', $route, [],  [], '', [], [], ["POST", "HEAD"]);
    }

    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     */
    public function direct(Request $request)
    {

        $requests = $request->AllRequestDataWithHeader();
        $context = new RequestContext('/', $request->method());
        $context->fromRequest($requests);
       // dd($requests);
        $matcher = new UrlMatcher($this->routes, $context);
       //dd($this->routes);
        try {
            $parameters = $matcher->match( $request->uri() );
            //dd($parameters);
            if(is_callable($parameters['_controller'])){
                $parameters['_controller']();
            }else{
                list($controller, $action) = explode('@', $parameters['_controller']);
                $this->callAction($controller, $action);
            }
        } catch (Exception $e) {
            throw new \Exception('No route defined for this URI.');
        }
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $action
     */
    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (! method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}
