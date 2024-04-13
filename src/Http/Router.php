<?php

namespace Mailer\Http;

use Mailer\Contracts\Request as BaseRequest;
use Mailer\Contracts\Route;
use Mailer\Contracts\Router as BaseRouter;
use Mailer\Http\Exceptions\RouteNotFoundException;

class Router extends BaseRouter
{
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
     * @param BaseRequest $request
     *
     * @throws \Exception
     *
     * @return Route
     */
    public function searchWithLoadedParams(BaseRequest $request): Route
    {
        $needle = $request->getRouteIdentifier();

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

        throw new RouteNotFoundException($needle);
    }

    /**
     * @return void
     */
    public function registerRoutes(): void
    {
        require_once __DIR__ . '/../../app/route.php';
    }
}
