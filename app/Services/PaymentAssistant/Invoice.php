<?php

namespace App\Services\PaymentAssistant;

abstract class Invoice
{
    public $description;

    protected $id;

    protected $summ;

    protected $product;

    protected $currency;

    /**
     * @param int|string $id
     * @param int|string $product
     * @param int|string $summ
     */
    public function __construct($id = null, $product = null, $summ = null)
    {
        $this->id = $id;
        $this->product = $product;
        $this->summ = $summ;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumm()
    {
        return $this->summ;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param int|string $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param int|string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }
}
