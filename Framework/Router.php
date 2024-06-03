<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middlewares\Authorize;

class Router
{
    protected static $routes = [];

    /**
     * @param string $method
     * @param string $uri
     * @param string $controller
     * @param $controllerMethod
     * @param array $middleware
     * @return void
     */
    public static function registerRoute(string $method, string $uri, string $controller, $controllerMethod, array $middleware = [])
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    /**
     * Add a GET route
     *
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @param array $middleware
     * @return void
     */
    public static function get(string $uri, string $controller, string $method, array $middleware = [])
    {
        self::registerRoute('GET', $uri, $controller, $method, $middleware);
    }

    /**
     * Add a POST route
     *
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @param array $middleware
     * @return void
     */
    public static function post(string $uri, string $controller, string $method, array $middleware = [])
    {
        self::registerRoute('POST', $uri, $controller, $method, $middleware);
    }

    /**
     * Add a PUT route
     *
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @param array $middleware
     * @return void
     */
    public static function put(string $uri, string $controller, string $method, array $middleware = [])
    {
        self::registerRoute('PUT', $uri, $controller, $method, $middleware);
    }

    /**
     * Add a DELETE route
     *
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @param array $middleware
     * @return void
     */
    public static function delete(string $uri, string $controller, string $method, array $middleware = [])
    {
        self::registerRoute('DELETE', $uri, $controller, $method, $middleware);
    }

    /**
     * Route the request
     *
     * @param string $uri
     */
    public static function route(string $uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Check for _method input
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            // Override the request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach (self::$routes as $route) {

            // Split the current URI into segments
            $uriSegments = explode('/', trim($uri, '/'));

            // Split the route URI into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;

            // Check if the number of segments matches
            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method']) === $requestMethod) {
                $params = [];

                for ($i = 0; $i < count($uriSegments); $i++) {
                    // If the uris do not match and there is no param
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    // Check for the param and add to $params array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
                    foreach ($route['middleware'] as $middleware) {
                        (new Authorize())->handle($middleware);
                    }

                    $controller = $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instantiate the controller
                    $controllerInstance = new $controller();

                    // Check if the method exists in the controller instance
                    if (method_exists($controllerInstance, $controllerMethod)) {
                        // Call the method if it exists
                        $methodRes = $controllerInstance->$controllerMethod($params);
                        echo $methodRes;
                        exit;
                    } else {
                        // Handle the error if the method does not exist
                        http_response_code(400);
                        header('Content-Type: application/json');
                        echo json_encode(['message' => "Method $controllerMethod on controller $controller does not exist."]);
                        exit;
                    }
                }
            }
        }

        ErrorController::notFound();
    }
}
