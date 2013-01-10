<?php

/**
 * PHP REST Client build with cURL
 * 
 * @author Fabio Agostinho Boris <fabioboris@gmail.com>
 */
class RestClient
{
    private $host;        // the url to the rest server
    private $user = null; // the username to the basic auth
    private $pwd = null;  // the password to the basic auth

    public function __construct($host, $user = null, $pwd = null)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
    }

    /**
     * Make an HTTP request using cURL
     * 
     * @param string $verb
     * @param string $url
     * @param array $params 
     */
    private function request($verb, $url, $params = null)
    {
    }

    /**
     * Make an HTTP GET request
     * 
     * @param string $url
     * @param array $params
     */
    public function get($url, $params = null)
    {
        return $this->request('GET', $url, $params);
    }

    /**
     * Make an HTTP POST request
     * 
     * @param string $url
     * @param array $params
     */
    public function post($url, $params = null)
    {
        return $this->request('POST', $url, $params);
    }

    /**
     * Make an HTTP PUT request
     * 
     * @param string $url
     * @param array $params
     */
    public function put($url, $params = null)
    {
        return $this->request('PUT', $url, $params);
    }

    /**
     * Make an HTTP DELETE request
     * 
     * @param string $url
     * @param array $params
     */
    public function delete($url, $params = null)
    {
        return $this->request('DELETE', $url, $params);
    }
}
