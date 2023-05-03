<?php

namespace Engine\Helper;

class Http
{

    /**
     * Fetch data from an API
     * 
     * @param string $url
     * @param array $data
     * @param string $method
     * @return mixed
     */
    public static function fetch(string $url, array $data = [], string $method = 'GET')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    /**
     * Fetch data from an API using GET method
     * 
     * @param string $url
     * @return mixed
     */
    public static function get(string $url)
    {
        return self::fetch($url);
    }

    /**
     * Fetch data from an API using POST method
     * 
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public static function post(string $url, array $data)
    {
        return self::fetch($url, $data, 'POST');
    }

    /**
     * Fetch data from an API using PUT method
     * 
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public static function put(string $url, array $data)
    {
        return self::fetch($url, $data, 'PUT');
    }

    /**
     * Fetch data from an API using DELETE method
     * 
     * @param string $url
     * @return mixed
     */
    public static function delete(string $url)
    {
        return self::fetch($url, [], 'DELETE');
    }
}
