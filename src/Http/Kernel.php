<?php

namespace Mailer\Http;

use Exception;
use Mailer\Contracts\Controller;
use Mailer\Contracts\Kernel as BaseKernel;
use Mailer\Contracts\Request as BaseRequest;
use Mailer\Contracts\Response as BaseResponse;
use Mailer\Http\Exceptions\UnprocessableEntity;

class Kernel extends BaseKernel
{
    /**
     * @var Router
     */
    protected Router $router;

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $this->router = new Router();

        $this->router->registerRoutes();
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function serve(Request $request): Response
    {
        if ($request instanceof Request && $request->isPreFlight()) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Content-Type');

            http_response_code(200);

            exit();
        }

        try {
            return $this->handle($request);
        } catch (UnprocessableEntity $e) {
            $res = new JsonResponse(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);

            $res->addHeader('HTTP/1.0', $e->getCode());

            return $res;
        } catch (Exception $e) {
            $res = new JsonResponse(['message' => $e->getMessage()]);

            $res->addHeader('HTTP/1.0', $e->getCode());

            return $res;
        }
    }

    /**
     * @inheritDoc
     *
     * @throws \Exception
     */
    public function handle(Request|BaseRequest $request): Response
    {
        $route = $this->router->searchWithLoadedParams($request);

        $request->setPaths($route->getParams());

        /** @var Controller $controllerClass */
        $controllerClass = $route->getControllerClass();

        /** @var BaseRequest $requestClass */
        $requestClass = $route->getRequestClass();

        if ($request instanceof Request && $request->isFormRequest()) {
            /** @var FormRequest $requestClass */
            $formRequest = new $requestClass;
            $request     = $formRequest->copyFromRequest($request);

            $errors = $request->validate();

            if (count($errors)) {
                throw new UnprocessableEntity($errors);
            }
        }

        $controller = $controllerClass::getInstance();

        /** @var Response $response */
        $response = call_user_func([$controller, $route->getMethod()], $request);

        return $response;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @inheritDoc
     */
    public function terminate(Response|BaseResponse $response): void
    {
        foreach ($response->getHeaders() as $header => $value) {
            header($header . ': ' . $value);
        }

        parent::terminate($response);
    }
}
