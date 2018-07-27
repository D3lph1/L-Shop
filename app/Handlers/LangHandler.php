<?php
declare(strict_types = 1);

namespace App\Handlers;

use App\Services\Caching\CachingRepository;
use App\Services\Utils\EnvironmentUtil;
use Illuminate\Contracts\Translation\Translator;

class LangHandler
{
    private const CACHE_KEY = 'localization.';

    private const CACHE_TTL = 86400;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var CachingRepository
     */
    private $cachingRepository;

    public function __construct(Translator $translator, CachingRepository $cachingRepository)
    {
        $this->translator = $translator;
        $this->cachingRepository = $cachingRepository;
    }

    public function handle(): array
    {
        $data = $this->build();
        if (EnvironmentUtil::inProduction()) {
            $key = self::CACHE_KEY . $this->translator->getLocale();
            return $this->cachingRepository->get($key, function () use ($data, $key) {
                $this->cachingRepository->set($key, $data, self::CACHE_TTL);

                return $data;
            });
        }

        return $data;
    }

    private function build(): array
    {
        $locale = $this->translator->getLocale();

        $files = glob(resource_path("lang/{$locale}/*.php"));
        $data = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $data[$name] = $this->translator->trans($name);
        }

        return $data;
    }
}
