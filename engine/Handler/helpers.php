<?php


if (!function_exists('request')) {
    /**
     * Get the request instance.
     * 
     * @return \Engine\Handler\Request
     */
    function request()
    {
        return new \Engine\Handler\Request();
    }
}

if (!function_exists('view')) {
    /**
     * Create a new view response instance.
     * 
     * @param string $view
     * @param array $data
     * @return ViewResponse
     */
    function view($view, $data = [])
    {
        return new Engine\Handler\Response\ViewResponse($view, $data);
    }
}

if (!function_exists('json')) {
    /**
     * Create a new json response instance.
     * 
     * @param array $data
     * @return JsonResponse
     */
    function json($data = [], $status = 200)
    {
        return new Engine\Handler\Response\JsonResponse($data, $status);
    }
}

if (!function_exists('redirect')) {
    /**
     * Create a new redirect response instance.
     * 
     * @param string $url
     * @return RedirectResponse
     */
    function redirect($url = '')
    {
        return new Engine\Handler\Response\RedirectResponse($url);
    }
}

if (!function_exists('abort')) {
    /**
     * Create a new abort response instance.
     * 
     * @param int $code
     * @return AbortResponse
     */
    function abort($code = 404, $message = null)
    {
        return new Engine\Handler\Response\AbortResponse($code, $message);
    }
}

if (!function_exists('url')) {
    /**
     * Create a relative url.
     * 
     * @param string $path
     * @return string
     */
    function url($path = '')
    {
        return request()->baseURL() . $path;
    }
}

if (!function_exists('route')) {
    /**
     * Create a relative url to the given route.
     * 
     * @param string $route
     * @param array $params
     * @return string
     */
    function route($route, $params = [])
    {
        $route = \App\Router::getUrl($route, $params);

        return url($route);
    }
}

if (!function_exists('asset')) {
    /**
     * Create a relative url to the public folder.
     * 
     * @param string $path
     * @return string
     */
    function asset($path = '')
    {
        return url($path);
    }
}
