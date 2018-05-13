<?php
declare(strict_types = 1);

namespace App\Services\Routing;

use Illuminate\Contracts\Config\Repository;

class SpaRouteResolver
{
    /**
     * @var Repository
     */
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function resolve(string $url): string
    {
        $app = $this->config->get('app.url');
        if ($app[mb_strlen($app) - 1] !== '/') {
            $app[mb_strlen($app)] = '/';
        }

        if ($url[0] === '/') {
            $url = mb_substr($url, 1);
        }

        return $app . $url;
    }
}
