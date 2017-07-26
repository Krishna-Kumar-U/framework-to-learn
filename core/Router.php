<?php

namespace App\Core;

use App\Core\Request;
use Symfony\Component\HttpFoundation\Request AS Requests;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

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
       try {
            $parameters = (new UrlMatcher($this->routes, $context))->match( $request->uri() , EXTR_SKIP);
            if(is_callable($parameters['_controller'])){
                $parameters['_controller']();
            }else{
                list($controller, $action) = explode('@', $parameters['_controller']);
                $this->callAction($controller, $action);
            }
       } catch (ResourceNotFoundException $e) {
            //$response = new Response('Not Found', 404);
            return view('errors.404'); 
       } catch (Exception $e) {
            //$response = new Response('An error occurred', 500);
            return view('errors.500');
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
