<?php

namespace Mailer\Http;

use Mailer\Contracts\Route;
use Mailer\Contracts\Router as BaseRouter;

class Router extends BaseRouter
{
    public const HTTP_NOT_FOUND = 404;

    /**
     * @param string $route
     * @param array  $action
     * @param string $request
     *
     * @return void
     */
    public function get(string $route, array $action, string $request = Request::class): void
    {
        $this->routes[$route . ':' . 'get'] = new Route($action[0], $action[1], $request);
    }

    /**
     * @param string $route
     * @param array  $action
     * @param string $request
     *
     * @return void
     */
    public function post(string $route, array $action, string $request = FormRequest::class): void
    {
        $this->routes[$route . ':' . 'post'] = new Route($action[0], $action[1], $request);
    }

    /**
     * @param string $route
     * @param string $method
     *
     * @throws \Exception
     *
     * @return Route
     */
    public function search(string $route, string $method): Route
    {
        $needle = $route . ':' . strtolower($method);

        foreach ($this->routes as $key => $route) {
            // domain/prefix/abc/another/2 - abc and 2 are values passed in as param, domain is variable
            $webUrlRegex = '~^.*?' . preg_replace('~\\\{([^}]+)\\\}~', '([^/]+)?', preg_quote($key, '~')) . '(?:/|$)~';

            if (!preg_match('/\{([^}]+)\}/', $needle) && preg_match($webUrlRegex, $needle, $pathValues)) {
                // prefix/{param1}/sub-path/{param2} - params are optional and can be multiple
                $baseUrlRegex = '/\/\w*\/(?:\{([^}]+)\}(?:\/\{([^}]+)\})*)?/';

                preg_match($baseUrlRegex, $key, $pathNames);

                array_shift($pathNames);
                array_shift($pathValues);

                $route->setParams(array_combine(array_filter($pathNames), array_filter($pathValues)));

                return $route;
            }
        }

        throw new \Exception('The route that you are looking for does not exists', self::HTTP_NOT_FOUND);
    }

    /**
     * @return void
     */
    public function registerRoutes(): void
    {
        require_once __DIR__ . '/../../app/route.php';
    }
}
