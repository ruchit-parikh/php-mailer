<?php

namespace Mailer\Http;

use Exception;
use Mailer\Contracts\Controller;
use Mailer\Contracts\Kernel as BaseKernel;
use Mailer\Contracts\Response as BaseResponse;
use Mailer\Http\Exceptions\UnprocessableEntity;

class Kernel extends BaseKernel
{
    /**
     * @inheritDoc
     */
    protected function getRouterClass(): string
    {
        return Router::class;
    }

    /**
     * @inheritDoc
     */
    protected function getRequestClass(): string
    {
        return Request::class;
    }

    /**
     * @inheritDoc
     *
     * @throws \Exception
     */
    public function serve(): Response
    {
        try {
            /** @var Request $request */
            $request = $this->request;

            $route = $this->router->search($request->getUrlPath(), $request->getMethod());

            $request->setPaths($route->getParams());

            /** @var Controller $controllerClass */
            $controllerClass = $route->getControllerClass();

            /** @var Request $requestClass */
            $requestClass = $route->getRequestClass();

            if ($request->isFormRequest()) {
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
        } catch (UnprocessableEntity $e) {
            header("HTTP/1.0 " . $e->getCode());

            return new JsonResponse(['message' => $e->getMessage(), 'errors' => $e->getErrors()]);
        } catch (Exception $e) {
            header("HTTP/1.0 " . $e->getCode());

            return new JsonResponse(['message' => $e->getMessage()]);
        }
    }

    /**
     * @inheritDoc
     */
    public function terminate(Response|BaseResponse $response): void
    {
        foreach ($response->getHeaders() as $header => $value) {
            header($header . ': ' . $value);
        }

        if ($this->request->isPreflight()) {
            http_response_code(200);

            exit();
        }

        parent::terminate($response);
    }
}
