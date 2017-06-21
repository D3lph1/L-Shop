<?php

namespace App\Services;

use App\Exceptions\User\InvalidUsernameException;
use App\Services\Distributors\Distributor;
use App\Services\Payments\Manager;
use App\Traits\BuyResponse;
use App\Traits\Validator;

/**
 * Class CatalogBuy
 * Responsible for processing the purchase of goods directly from the catalog
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class CatalogBuy
{
    use BuyResponse;

    use Validator;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var Distributor
     */
    private $distributor;

    public function __construct()
    {
        $this->manager = \App::make('payment.manager');
        $this->distributor = \App::make('distributor');
    }

    /**
     * Method - handler
     *
     * @param int         $productId
     * @param int         $productCount
     * @param int         $server
     * @param string      $ip
     * @param null|string $username
     * @throws InvalidUsernameException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy($productId, $productCount, $server, $ip, $username = null)
    {
        $productId = [$productId];
        $productCount = [$productCount];

        $this->manager
            ->setServer($server)
            ->setIp($ip);

        $this->username($username);

        if (!is_auth() and $username) {
            $this->manager->setUsername($username);
        }

        $payment = null;
        \DB::transaction(function () use ($productId, $productCount, &$payment) {
            $payment = $this->manager->createPayment($productId, $productCount, Manager::COUNT_TYPE_NUMBER);
            if ($payment->completed) {
                $this->distributor->give($payment);
            }
        });

        return $this->buildResponse($server, $payment);
    }

    /**
     * @param null|string $username
     */
    private function username($username = null)
    {
        if (!is_auth()) {
            $validated = $this->validateUsername($username, false);
            if (!$validated) {
                throw new InvalidUsernameException();
            }
        }
    }
}
