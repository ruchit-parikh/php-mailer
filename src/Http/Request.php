<?php

namespace Mailer\Http;

use Mailer\Contracts\Request as BaseRequest;

class Request extends BaseRequest
{
    const HTTP_NOT_FOUND = 404;
    const UNPROCESSABLE_ENTITY = 422;

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
     * @var array
     */
    protected array $paths;

    /**
     * @inheritDoc
     */
    public function collectData(): void
    {
        $this->query = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->paths = [];

        if ($this->isNotEncodedPostRequest()) {
            parse_str(file_get_contents('php://input'), $data);

            $this->post = $data;
        }
    }

    /**
     * @return bool
     */
    private function isNotEncodedPostRequest(): bool
    {
        $contextType = $this->server['CONTENT_TYPE'] ?? '';

        return str_starts_with($contextType, 'application/x-www-form-urlencoded')
            && \in_array($this->getMethod(), ['PUT', 'DELETE', 'PATCH', 'POST']);
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
    public function getUrlPath(): string
    {
        return rtrim($this->server['PHP_SELF'], '/');
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
     * @param string|null $key
     *
     * @return mixed
     */
    public function path(string $key = null): mixed
    {
        return $key ? $this->paths[$key] ?? null : $this->paths;
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
     * @param array $paths
     *
     * @return $this
     */
    public function setPaths(array $paths): static
    {
        $this->paths = $paths;

        return $this;
    }
}
