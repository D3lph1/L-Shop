<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Control\Optimization;

use App\Services\Response\JsonRespondent;

class VisitResult implements JsonRespondent
{
    /**
     * @var int
     */
    private $monitoringTtl;

    /**
     * @param int $monitoringTtl
     *
     * @return VisitResult
     */
    public function setMonitoringTtl(int $monitoringTtl): VisitResult
    {
        $this->monitoringTtl = $monitoringTtl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function response(): array
    {
        return [
            'monitoringTtl' => $this->monitoringTtl
        ];
    }
}
