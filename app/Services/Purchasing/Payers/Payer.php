<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Payers;

use App\Entity\Purchase;

/**
 * Interface Payer
 * In the context of this project payer is a payment service. Interface represents abstraction
 * for payment service.
 */
interface Payer
{
    /**
     * Returns the url by which the user needs to go to start paying.
     *
     * @param Purchase $purchase
     *
     * @return string
     */
    public function paymentUrl(Purchase $purchase): string;

    /**
     * Validates an array of incoming data by whether the data in it is valid payment data.
     * These data are usually taken from a request that the payment service performs in
     * order to notify the store of the successful payment.
     *
     * @param array $data
     *
     * @return bool True - data is valid.
     */
    public function validate(array $data): bool;

    /**
     * Retrieves purchase identifier from an array of incoming data.
     * These data are usually taken from a request that the payment service performs in
     * order to notify the store of the successful payment.
     *
     * @param array $data
     *
     * @return int
     */
    public function purchaseId(array $data): int;

    /**
     * Returns the string that the payment service expects to receive in case of successful
     * processing of the notification request by the shop.
     *
     * @param Purchase $purchase
     *
     * @return string
     */
    public function successAnswer(Purchase $purchase): string;

    /**
     * Returns the name of the payment service.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Returns true - if the service is on, false - if disabled.
     *
     * @return bool
     */
    public function enabled(): bool;
}
