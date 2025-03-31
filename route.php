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
        $uri = rtrim($uri, '/') ?: '/';
        if (isset(self::$routes[$method][$uri])) {
          
            return self::callController(self::$routes[$method][$uri], []);
        }
        if (isset(self::$routes[$method])) {
            
            foreach (self::$routes[$method] as $route => $controller) {
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([A-Za-z0-9\-]+)', $route);
                $pattern = str_replace('/', '\/', $pattern);
                if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                    array_shift($matches);
                    return self::callController($controller, $matches);
                }
            }
        }
        http_response_code(404);
        $errorCode = 404;
        $errorMessage = "lỗi";
        require __DIR__ . '/App/Views/Error/Error.php';
        exit;
    }

    private static function callController($controllerAction, $params) {
        $controllerAction = explode('@', $controllerAction);
        $controller = "App\\Controllers\\" . $controllerAction[0];
        $action = $controllerAction[1];
    
        if (class_exists($controller)) {
            $instance = new $controller();
            if (method_exists($instance, $action)) {
                return call_user_func_array([$instance, $action], $params);
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
