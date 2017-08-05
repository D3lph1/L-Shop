<?php

namespace App\Services\Payments\Robokassa;

class Payment
{
    /**
     * @var int
     */
    protected $number;

    /**
     * @var string
     */
    protected $amount;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $culture;

    /**
     * @var string
     */
    protected $currencyLabel;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var array
     */
    protected $customParams = [];

    /**
     * Payment constructor.
     *
     * @param int   $number
     * @param float $amount
     */
    public function __construct($number, $amount)
    {
        $this->number = $number;
        $this->amount = number_format($amount, 2, '.', '');
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCulture()
    {
        return $this->culture;
    }

    /**
     * @param string $culture
     *
     * @return $this
     */
    public function setCulture($culture)
    {
        $this->culture = $culture;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyLabel()
    {
        return $this->currencyLabel;
    }

    /**
     * @param string $currencyLabel
     *
     * @return $this
     */
    public function setCurrencyLabel($currencyLabel)
    {
        $this->currencyLabel = $currencyLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addCustomParam($name, $value)
    {
        $this->customParams['shp_' . $name] = $value;
    }

    public function hasCustomParam($name)
    {
        return isset($this->customParams['shp_' . $name]);
    }

    public function getCustomParam($name)
    {
        if ($this->hasCustomParam($name)) {
            return $this->customParams['shp_' . $name];
        }

        return null;
    }

    public function getCustomParams()
    {
        return $this->customParams;
    }
}
