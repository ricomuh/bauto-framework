<?php

namespace Engine\Authorization;

class Middleware
{
    /**
     * List of middleware
     * 
     * @var array
     */
    protected $middleware = [];

    /**
     * Check middleware
     * 
     * @param string $middleware
     * @return mixed
     */
    public function check(string $middleware)
    {
        if (isset($this->middleware[$middleware])) {
            $method = $this->middleware[$middleware];
            return $this->$method();
        }
        return false;
    }
}
