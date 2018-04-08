<?php

class Route
{

    private static $routes = [];

    private $route;
    private $controller;
    private $action;
    private $method;

    public function __construct($route, $path, $method = 'GET') {

        $path = preg_split('/@/', $path);

        $route = preg_replace('/\//', '\\/', $route);

        $route = preg_replace_callback('/\{([a-z]+)(?:\:([^\}]+))?\}/', function($match) {
            return empty($match[2]) ? "(?P<$match[1]>[a-z]+)" : "(?P<$match[1]>$match[2])";
        }, $route);

        $this->route = '/^' . $route . '$/';

        $this->controller = $path[0];

        $this->action = (empty($path[1])) ? 'index' : $path[1];

        $this->method = $method;
    }



    public static function get($route, $path) {
        self::$routes[] = new Route($route, $path, 'GET');
    }

    public static function post($route, $path) {
        self::$routes[] = new Route($route, $path, 'POST');
    }

    public static function dispatch($url) {
        $url = self::parseUrl($url);
        foreach (self::$routes as $route) {
            if (preg_match($route->route, $url, $matches)) {
                $controller_name = $route->controller;
                if (class_exists($controller_name)) {
                    $controller = new $controller_name();

                    $action = $route->action;

                    if (is_callable([$controller, $action])) {
                        $args = [];
                        foreach ($matches as $key => $match) {
                            if (is_string($key)) {
                                $args[$key] = $match;
                            }
                        }
                        call_user_func_array(array($controller, $action), $args);
                        return true;
                    }
                }
            }
        }
    }

    private static function parseUrl($url) {

        $split = explode('&', $url, 2);

        $url = (strpos($split[0], '=') === false) ? $split[0] : $url;

        return $url;
    }
}