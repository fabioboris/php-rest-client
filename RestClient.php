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
     * Returns the absolute URL
     * 
     * @param string $url
     */
    private function url($url = null)
    {
        $_host = rtrim($this->host, '/');
        $_url = ltrim($url, '/');

        return "{$_host}/{$_url}";
    }

    /**
     * Returns the URL with encoded query string params
     * 
     * @param string $url
     * @param array $params
     */
    private function urlQueryString($url, $params)
    {
        $qs = array();
        if ($params) {
            foreach ($params as $key => $value) {
                $qs[] = "{$key}=" . urlencode($value);
            }
        }

        $url = explode('?', $url);
        if ($url[1]) $url_qs = $url[1];
        $url = $url[0];
        if ($url_qs) $url = "{$url}?{$url_qs}";

        if (count($qs)) return "{$url}?" . implode('&', $qs);
        else return $url;
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
        $ch = curl_init();       // the cURL handler
        $url = $this->url($url); // the absolute URL

        // encoded query string on GET and DELETE
        switch ($verb) {
            case 'GET':
            case 'DELETE':
            $url = $this->urlQueryString($url, $params);
        }

        // set the URL
        curl_setopt($ch, CURLOPT_URL, $url);

        // username and password when supplied
        if ($this->user and $this->pwd) {
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->user}:{$this->pwd}");
        }

        // set the HTTP verb for the request
        switch ($verb) {
            case 'POST':
            curl_setopt($ch, CURLOPT_POST, true);
            break;
            case 'PUT':
            case 'DELETE':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        }

        // set the input params
        switch ($verb) {
            case 'POST':
            case 'PUT':
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        // will return the response content as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch); // the response content
        curl_close($ch);            // close the cURL handler

        return $response;
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
