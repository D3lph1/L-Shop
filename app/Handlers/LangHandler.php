<?php
declare(strict_types = 1);

namespace App\Handlers;

use App\Services\Caching\CachingRepository;
use App\Services\Utils\EnvironmentUtil;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Translation\Translator;

class LangHandler
{
    private const CACHE_KEY = 'localization';

    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var CachingRepository
     */
    private $cachingRepository;

    public function __construct(Repository $config, Translator $translator, CachingRepository $cachingRepository)
    {
        $this->config = $config;
        $this->translator = $translator;
        $this->cachingRepository = $cachingRepository;
    }

    public function handle(): array
    {
        $data = $this->build();
        if (EnvironmentUtil::inProduction()) {
            return $this->cachingRepository->get(self::CACHE_KEY, function () use ($data) {
                $this->cachingRepository->set(self::CACHE_KEY, $data);

                return $data;
            });
        }

        return $data;
    }

    private function build(): array
    {
        $locale = $this->config->get('app.locale');

        $files = glob(resource_path("lang/{$locale}/*.php"));
        $data = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $data[$name] = $this->translator->trans($name);
        }

        return $data;
    }
}
