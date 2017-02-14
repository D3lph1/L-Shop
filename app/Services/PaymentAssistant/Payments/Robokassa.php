<?php

namespace App\Services\PaymentAssistant\Payments;

use App\Services\PaymentAssistant\Payment;
use App\Services\PaymentAssistant\Invoices\Robokassa as Invoice;

class Robokassa extends \App\Services\PaymentAssistant\Payment
{
    /**
     * @var string
     */
    protected $url = 'http://auth.robokassa.ru/Merchant/Index.aspx';

    /**
     * User robokassa login
     *
     * @var string
     */
    private $login;

    /**
     * User robokassa password
     *
     * @var string
     */
    private $password;

    /**
     * Hashing algorithm
     *
     * @var string
     */
    private $algo;

    /**
     * Enable test mode
     *
     * @var bool
     */
    private $test;

    /**
     * @param string $login
     * @param string $password
     * @param string $algo
     * @param bool $test
     */
    public function __construct($login, $password, $algo = 'sha512', $test = false)
    {
        $this->login = $login;
        $this->password = $password;
        $this->algo = $algo;
        $this->test = $test;
    }

    /**
     * @param null|int|string $id
     * @param null|int|string $product
     * @param null|int|string $summ
     * @return Invoice
     */
    public function make($id = null, $product = null, $summ = null)
    {
        return new Invoice($id, $product, $summ);
    }

    /**
     * Build and return query url
     *
     * @param $invoice
     * @return string
     */
    public function build($invoice)
    {
        if (!$invoice instanceof Invoice) {
            throw new \InvalidArgumentException(
                'Argument $invoice must be type "\D3lph1\PaymentAssistant\Invoices\Robokassa"'
            );
        }

        $data = [
            'MrchLogin' => $this->login,
            'OutSum' => $invoice->getSumm(),
            'InvId' => $invoice->getId(),
            'IncCurrLabel' => $invoice->getCurrency(),
            'Desc' => $invoice->description,
            'SignatureValue' => $this->hashing($this->buildSignature($invoice)),
            'Shp_item' => $invoice->getProduct(),
            'Culture' => $invoice->getLang(),
            'Encoding' => $invoice->getEncoding(),
            'IsTest' => (int) $this->test
        ];

        $params = http_build_query($data);

        return $this->url . '?' . $params;
    }

    private function buildSignature($invoice)
    {
        $data = [
            $this->login,
            $invoice->getSumm(),
            $invoice->getId(),
            $this->password,
            'Shp_item=' . $invoice->getProduct()
        ];

        return implode(':', $data);
    }

    /**
     * Hashing input string by declared hashing algorithm
     *
     * @param string $string
     * @return string
     */
    private function hashing($string)
    {
        return hash($this->algo, $string);
    }
}
