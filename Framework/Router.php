<?php

namespace Framework;

use App\Controllers\ErrorController;
use Exception;
use Framework\Middlewares\Authorize;

class Router
{
    // Declare static property with correct syntax and visibility
    protected static $routes = [];

    /**
     * @param string $method
     * @param string $uri
     * @param string $action
     * @param array $middleware
     * @return void
     */
    public static function registerRoute(string $method, string $uri, string $action, array $middleware = [])
    {
        list($controller, $controllerMethod) = explode('@', $action);

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
     * @param array $middleware
     * @return void
     */
    public static function get($uri, $controller, $middleware = [])
    {
        self::registerRoute('GET', $uri, $controller, $middleware);
    }

    /**
     * Add a POST route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public static function post($uri, $controller, $middleware = [])
    {
        self::registerRoute('POST', $uri, $controller, $middleware);
    }

    /**
     * Add a PUT route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public static function put($uri, $controller, $middleware = [])
    {
        self::registerRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     * Add a DELETE route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public static function delete($uri, $controller, $middleware = [])
    {
        self::registerRoute('DELETE', $uri, $controller, $middleware);
    }

    /**
     * Route the request
     *
     * @param string $uri
     */
    public static function route($uri)
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

                    $controller = 'App\\Controllers\\' . $route['controller'];
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
