<?php

class Router {
    private static $routes = [];

    public static function get($uri, $controller) {
        self::$routes['GET'][$uri] = $controller;
    }

    public static function post($uri, $controller) {
        self::$routes['POST'][$uri] = $controller;
    }

    
    public static function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset(self::$routes[$method][$uri])) {
            $controllerAction = explode('@', self::$routes[$method][$uri]);
            $controller = "App\\Controllers\\" . $controllerAction[0];
            $action = $controllerAction[1];
            if (class_exists($controller)) {
                $instance = new $controller();
                if (method_exists($instance, $action)) {
                    return $instance->$action();
                }
            }
        }
        
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = "lỗi";
        require __DIR__ . '/App/Views/Error/Error.php';
        exit;
    }
}
?>
