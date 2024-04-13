<?php

namespace Mailer\Http;

use Mailer\Contracts\Request as BaseRequest;

class Request extends BaseRequest
{
    public const HTTP_NOT_FOUND       = 404;
    public const UNPROCESSABLE_ENTITY = 422;

    /**
     * @var array
     */
    private array $query;

    /**
     * @var array
     */
    private array $post;

    /**
     * @var array
     */
    private array $files;

    /**
     * @var array
     */
    private array $server;

    /**
     * @param array $get
     * @param array $post
     * @param array $files
     * @param array $server
     */
    public function __construct(array $get = [], array $post = [], array $files = [], array $server = [])
    {
        $this->query  = $get;
        $this->post   = $post;
        $this->files  = $files;
        $this->server = $server;
    }

    /**
     * @inheritDoc
     */
    public static function prepareRequest(): static
    {
        $post                 = $_POST;
        $contextType          = $_SERVER['CONTENT_TYPE'] ?? '';
        $isContentTypeJSON    = $contextType === 'application/json';
        $isEncodedPostRequest = (str_starts_with($contextType, 'application/x-www-form-urlencoded') || str_starts_with($contextType, 'multipart/form-data'))
            && \in_array(strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'), ['PUT', 'DELETE', 'PATCH', 'POST']);

        if (!$isEncodedPostRequest && $isContentTypeJSON) {
            $data = file_get_contents('php://input');
            $post = json_decode($data, true);
        }

        return new static($_GET, $post, $_FILES, $_SERVER);
    }

    /**
     * @return bool
     */
    public function isFormRequest(): bool
    {
        return in_array($this->getMethod(), ['PUT', 'POST', 'PATCH']);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * @return string
     */
    public function getRouteIdentifier(): string
    {
        return rtrim($this->server['PHP_SELF'], '/') . ':' . strtolower($this->getMethod());
    }

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function query(string $key = null): mixed
    {
        return $key ? $this->query[$key] ?? null : $this->query;
    }

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function post(string $key = null): mixed
    {
        return $key ? $this->post[$key] ?? null : $this->post;
    }

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function file(string $key = null): mixed
    {
        return $key ? $this->files[$key] ?? null : $this->files;
    }

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function server(string $key = null): mixed
    {
        return $key ? $this->server[$key] ?? null : $this->server;
    }

    /**
     * @param array $query
     *
     * @return $this
     */
    public function setQuery(array $query = []): static
    {
        $this->query = $query;

        return $this;
    }


    /**
     * @param array $data
     *
     * @return $this
     */
    public function setPost(array $data = []): static
    {
        $this->post = $data;

        return $this;
    }


    /**
     * @param array $files
     *
     * @return $this
     */
    public function setFiles(array $files): static
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @param array $server
     *
     * @return $this
     */
    public function setServerConfigs(array $server): static
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPreFlight(): bool
    {
        return $this->getMethod() === 'OPTIONS';
    }
}
