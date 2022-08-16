<?php
namespace Routes;
use DbConnection\Db;
use Exception;
use Routes\Controller;
class Route
{
    private static array $routes;
    public function __construct() {

    }
    public static function get($url, $method) {
        self::$routes['GET' . $url] = $method;
    }

    public static function post($url, $method) {
        self::$routes['POST' . $url] = $method;
    }
    public static function handleRequest($httpMethod, $url) {
        if(in_array(self::$routes[$httpMethod . $url], self::$routes)) {
            $method = self::$routes[$httpMethod . $url];
        }
        else {
            throw new Exception('Route not found');
        }
        echo json_encode((new Controller())->$method());

    }
}