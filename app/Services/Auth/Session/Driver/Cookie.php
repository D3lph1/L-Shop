<?php
declare(strict_types = 1);

namespace App\Services\Auth\Session\Driver;

use Illuminate\Config\Repository;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class Cookie implements Driver
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var CookieJar
     */
    private $cookie;

    /**
     * @var Repository
     */
    private $config;

    public function __construct(Request $request, CookieJar $cookie, Repository $config)
    {
        $this->request = $request;
        $this->cookie = $cookie;
        $this->config = $config;
    }

    public function get(): ?string
    {
        return $this->request->cookie($this->config->get('auth.cookie'));
    }

    public function set(string $persistenceCode): void
    {
        $this->cookie->queue(
            $this->config->get('auth.cookie'),
            $persistenceCode,
            $this->config->get('auth.persistence.lifetime')
        );
    }

    public function forget(): void
    {
        $this->cookie->queue($this->cookie->forget($this->config->get('auth.cookie')));
    }
}
