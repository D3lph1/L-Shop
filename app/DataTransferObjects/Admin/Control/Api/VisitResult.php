<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Control\Api;

use App\Services\Response\JsonRespondent;

class VisitResult implements JsonRespondent
{
    /**
     * @var bool
     */
    private $apiEnabled;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string|null
     */
    private $delimiter;

    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var bool
     */
    private $apiAuthEnabled;

    /**
     * @var bool
     */
    private $apiRegisterEnabled;

    /**
     * @var bool
     */
    private $sashok724sV3LauncherEnabled;

    /**
     * @var string
     */
    private $sashok724sV3LauncherFormat;

    /**
     * @var string[]
     */
    private $sashok724sV3LauncherIPs;

    /**
     * @param bool $apiEnabled
     *
     * @return VisitResult
     */
    public function setApiEnabled(bool $apiEnabled): VisitResult
    {
        $this->apiEnabled = $apiEnabled;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return VisitResult
     */
    public function setKey(string $key): VisitResult
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string|null $delimiter
     *
     * @return VisitResult
     */
    public function setDelimiter(?string $delimiter): VisitResult
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @param string $algorithm
     *
     * @return VisitResult
     */
    public function setAlgorithm(string $algorithm): VisitResult
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @param bool $apiAuthEnabled
     *
     * @return VisitResult
     */
    public function setApiAuthEnabled(bool $apiAuthEnabled): VisitResult
    {
        $this->apiAuthEnabled = $apiAuthEnabled;

        return $this;
    }

    /**
     * @param bool $apiRegisterEnabled
     *
     * @return VisitResult
     */
    public function setApiRegisterEnabled(bool $apiRegisterEnabled): VisitResult
    {
        $this->apiRegisterEnabled = $apiRegisterEnabled;

        return $this;
    }

    /**
     * @param bool $sashok724sV3LauncherEnabled
     *
     * @return VisitResult
     */
    public function setSashok724SV3LauncherEnabled(bool $sashok724sV3LauncherEnabled): VisitResult
    {
        $this->sashok724sV3LauncherEnabled = $sashok724sV3LauncherEnabled;

        return $this;
    }

    /**
     * @param string $sashok724sV3LauncherFormat
     *
     * @return VisitResult
     */
    public function setSashok724SV3LauncherFormat(string $sashok724sV3LauncherFormat): VisitResult
    {
        $this->sashok724sV3LauncherFormat = $sashok724sV3LauncherFormat;

        return $this;
    }

    /**
     * @param string[] $sashok724sV3LauncherIPs
     *
     * @return VisitResult
     */
    public function setSashok724SV3LauncherIPs(array $sashok724sV3LauncherIPs): VisitResult
    {
        $this->sashok724sV3LauncherIPs = $sashok724sV3LauncherIPs;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'apiEnabled' => $this->apiEnabled,
            'key' => $this->key,
            'delimiter' => $this->delimiter,
            'algorithm' => $this->algorithm,
            'apiAuthEnabled' => $this->apiAuthEnabled,
            'apiRegisterEnabled' => $this->apiRegisterEnabled,
            'sashok724sV3LauncherEnabled' => $this->sashok724sV3LauncherEnabled,
            'sashok724sV3LauncherFormat' => $this->sashok724sV3LauncherFormat,
            'sashok724sV3LauncherIPs' => $this->sashok724sV3LauncherIPs,
        ];
    }
}
