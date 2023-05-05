<?php

define('ROOT', dirname(__DIR__ . '/../../../..'));

if (!function_exists('str')) {
    /**
     * Create a new stringable object from the given string.
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    function str($string = '')
    {
        return new \Engine\Helper\Stringable($string);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     * 
     * @param mixed ...$args
     * @return void
     */
    function dd(...$args)
    {
        foreach ($args as $arg) {
            echo view('framework/dd', ['arg' => $arg]);
        }
        die();
    }
}


if (!function_exists('collect')) {
    /**
     * Create a new collection instance.
     * 
     * @param array $items
     * @return \Engine\Helper\Collection
     */
    function collect($items = [])
    {
        return new \Engine\Helper\Collection($items);
    }
}


if (!function_exists('env')) {
    /**
     * Get the value of an environment variable.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = $_ENV[$key] ?? null;

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && str_starts_with($value, '"') && str_ends_with($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (!function_exists('cache')) {
    /**
     * Create a new cache instance.
     * 
     * @param string $key
     * @param mixed $value
     * @param int $minutes
     * @return Cache
     */
    function cache()
    {
        return new Engine\Helper\Cache();
    }
}

if (!function_exists('faker')) {
    /**
     * Create a new faker instance.
     * 
     * @param string $locale
     * @return Faker\Generator
     */
    function faker(string $locale = 'en_US')
    {
        return Faker\Factory::create($locale);
    }
}
