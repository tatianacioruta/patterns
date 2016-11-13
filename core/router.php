<?php

class Router
{
    /**
     * Start app router
     */
    static function start()
    {
        $controller_name = 'home';
        $action_name = 'index';

        $routes = $_SERVER['REQUEST_URI'];
        $routes_parts = (explode('?', $routes));
        $routes = array_shift($routes_parts);
        $query_string = implode('', $routes_parts);
        $routes = explode('/', $routes);

        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        if (!empty($routes[2])) {
            $action_name = $routes[2];

        }

        $model_name = $controller_name . '_model';

        $model_file = strtolower($model_name) . '.php';
        $model_path = "application/models/" . $model_file;
        if (file_exists($model_path)) {
            require_once _ABS_PATH . "models/" . $model_file;
        }

        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = _ABS_PATH . "controllers/" . $controller_file;
        if (file_exists($controller_path)) {
            require_once _ABS_PATH . "controllers/" . $controller_file;
        }

        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            $_SERVER['REQUEST_URI'] = "/" . $controller_name . '/' . $action;
            if (!empty($query_string)) {
                $_SERVER['REQUEST_URI'] .= '?' . $query_string;
            }
            $controller->$action();
        }

    }

    /**
     * Page 404
     */
    static function page404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}