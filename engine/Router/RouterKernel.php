<?php

namespace Engine\Router;

use Engine\Handler\Request;
use Engine\Handler\Response\RedirectResponse;
use Engine\Authorization\Middleware;

class RouterKernel
{
    use URLParser;

    /**
     * Route
     * 
     * @var Route
     */
    public $route;

    /**
     * Request
     * 
     * @var Request
     */
    public $request;

    /**
     * The middleware
     * 
     * @var Middleware
     */
    protected $middleware;

    /**
     * The middleware instance
     * 
     * @var Middleware
     */
    protected $middlewareInstance;

    /**
     * RouterKernel constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->route = new Route();
        $this->request = new Request();
        $this->middlewareInstance = new $this->middleware();
    }

    /**
     * Application routes
     * 
     * @param Route $route
     * @return void
     */
    public function application(Route $route)
    {
    }

    /**
     * Handle the request
     * 
     * @return void
     */
    public function handle()
    {
        $this->application($this->route);
        $routes = $this->route->getRoutes();

        $returned = $this->checkRoute($routes, function ($route, $params) {
            $paramsValues = [];
            foreach ($params as $param) {
                $paramsValues[] = $this->request->path[$param['index']];
            }

            $this->runMethod($route['controller'], $route['method'], $paramsValues, $params);
        });

        if (!$returned) {
            echo abort(404);
        }
    }

    /**
     * Check the route
     * 
     * @param array $routes
     * @param callable $callback
     * @return bool
     */
    public function checkRoute(array $routes, callable $callback)
    {
        foreach ($routes as $route) {
            if (count($route['path']) != count($this->request->path)) continue;
            if ($route['type'] != $this->request->method()) continue;

            $matchedPath = 0;
            $params = [];

            foreach ($route['path'] as $key => $path) {
                if ($path == $this->request->path[$key]) {
                    $matchedPath++;
                } else if (preg_match('/^:/', $path)) {
                    $params[] = [
                        'index' => $key,
                        'name' => preg_replace('/^:/', '', $path),
                    ];
                    $matchedPath++;
                }
            }

            if ($matchedPath == count($route['path'])) {
                if (isset($route['middleware'])) {
                    $middleware = $this->middlewareInstance->check($route['middleware']);
                    if ($middleware !== true) {
                        if ($middleware instanceof RedirectResponse) {
                            $middleware->render();
                        }
                        return false;
                    }
                }


                $callback($route, $params);

                return true;
            }
        }

        return false;
    }

    /**
     * Run the controller method
     * 
     * @param string $controller
     * @param string $method
     * @param array $params
     * @return void
     */
    public function runMethod($controller, $method, $params, $paramsInfo = [])
    {
        $methodParams = (new \ReflectionMethod($controller, $method))->getParameters();

        foreach ($methodParams as $key => $param) {
            // check if the parameter is dont have specific type or primitive type
            if (!$param->hasType() || $param->getType()->isBuiltin())
                continue;

            // check if the parameter is a model
            $model = $param->getType()->getName();
            if (str($model)->contains('\\Models\\')) {
                $params[$key] = new $model(true, [
                    $paramsInfo[$key]['name'] => $params[$key]
                ]);

                if (!$params[$key]->isExists()) {
                    echo abort(404);
                    return;
                }
            } else if ($model == 'Engine\Handler\Request') {
                $params[$key] = $this->request;
            }

            if ($param->isDefaultValueAvailable() && !isset($params[$key])) {
                $params[$key] = $param->getDefaultValue();
            }

            if (!isset($params[$key])) {
                echo abort(404);
                return;
            }
        }

        // execute the controller method
        $this->execute($controller, $method, $params);
    }

    /**
     * Run the controller method
     * 
     * @param string $controller
     * @param string $method
     * @param array $params
     * @return void
     */
    public function execute($controller, $method, $params = [])
    {
        $controller = new $controller();
        $response = $controller->$method(...$params);

        $this->renderResponse($response);
    }

    /**
     * Render the response
     * 
     * @param mixed $response
     * @return void
     */
    public function renderResponse($response)
    {
        if ($response instanceof RedirectResponse) {
            $response->render();
            return;
        } else {
            echo $response;
            return;
        }
    }

    /**
     * Get the url of the route
     * 
     * @param string $route
     * @param array $params
     * @return string|null
     */
    public static function getUrl($route, $params = [])
    {
        $routeClass = new static;
        $routeClass->application($routeClass->route);

        $routes = $routeClass->route->getRoutes();

        foreach ($routes as $routePath) {
            if ($routePath['name'] == $route) {
                $url = $routePath['uri'];
                foreach ($params as $key => $param) {
                    $url = str_replace(':' . $key, $param, $url);
                }

                $url = str_replace('//', '/', $url);

                return $url;
            }
        }

        return null;
    }
}
