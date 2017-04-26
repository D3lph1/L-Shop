<?php

namespace App\Services;

use App\Repositories\PaymentRepository;

/**
 * Class Statistic
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Statistic
{
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;

    /**
     * Statistic constructor.
     *
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function forTheLastYearCompleted()
    {
        return $this->paymentRepository->forTheLastYearCompleted(['products', 'updated_at']);
    }

    /**
     * @return int
     */
    public function profit()
    {
        return $this->paymentRepository->profit();
    }
}
