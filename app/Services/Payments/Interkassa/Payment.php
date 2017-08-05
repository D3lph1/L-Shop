<?php

namespace App\Services\Payments\Interkassa;

class Payment
{
    /**
     * @var int|string Payment number
     */
    protected $number;

    /**
     * @var float Amount of payment
     */
    protected $amount;

    /**
     * Type of payment amount. Allows you to specify the strategy for calculating the
     * payment amount of the cashier and the payment system. Depending on it, the
     * calculation is based on a certain amount. If the amount type "invoice"
     * is specified, the payment amount in the payment system is calculated
     * from the payment amount of the cashier. If the type of the amount
     * is "payway" - then vice versa. The default is "invoice".
     *
     * @var string
     */
    protected $amountType;

    /**
     * @var string Currency of payment
     */
    protected $currency;

    /**
     * @var string Description of payment
     */
    protected $description;

    /**
     *
     * Expiry date of payment. Does not allow the customer to pay the payment after the
     * specified period. If he made a payment, the funds are credited to his personal
     * account in the Interkassa system. The parameter is used if the payment is tied
     * to an order, which quickly loses its relevance with the expiration of time.
     *
     * @var \DateTime
     */
    protected $expired;

    /**
     * The lifetime of the payment. Indicates in seconds the expiry date of the payment
     * after its creation. Not used if the expiration date of the payment is set.
     *
     * @var int
     */
    protected $lifetime;

    /**
     * Included payment methods. Allows you to specify the available payment methods for the customer.
     *
     * @var array
     */
    protected $paywayOn = [];

    /**
     * Disabled payment methods. Allows you to specify inaccessible payment methods for the customer.
     *
     * @var array
     */
    protected $paywayOff = [];

    /**
     * The selected payment method. Allows you to specify the exact payment method for the customer.
     *
     * @var array
     */
    protected $paywayVia = [];

    /**
     * @var string Locale of payment.
     */
    protected $locale;

    /**
     * @var array
     */
    protected $customParams = [];

    /**
     * Payment constructor.
     *
     * @param int|string $number Payment number
     * @param float      $amount Amount of payment
     */
    public function __construct($number, $amount)
    {
        $this->number = $number;
        $this->amount = (float)$amount;
    }

    /**
     * @return int|string
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
    public function getAmountType()
    {
        return $this->amountType;
    }

    /**
     * @param string $amountType
     *
     * @return $this
     */
    public function setAmountType($amountType)
    {
        $this->amountType = $amountType;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
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
     * @return \DateTime
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param \DateTime $expired
     *
     * @return $this
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param int $lifetime
     *
     * @return $this
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * @return array
     */
    public function getPaywayOn()
    {
        return $this->paywayOn;
    }

    /**
     * @param array $paywayOn
     *
     * @return $this
     */
    public function setPaywayOn($paywayOn)
    {
        $this->paywayOn = $paywayOn;

        return $this;
    }

    /**
     * @return array
     */
    public function getPaywayOff()
    {
        return $this->paywayOff;
    }

    /**
     * @param array $paywayOff
     *
     * @return $this
     */
    public function setPaywayOff($paywayOff)
    {
        $this->paywayOff = $paywayOff;

        return $this;
    }

    /**
     * @return array
     */
    public function getPaywayVia()
    {
        return $this->paywayVia;
    }

    /**
     * @param array $paywayVia
     *
     * @return $this
     */
    public function setPaywayVia($paywayVia)
    {
        $this->paywayVia = $paywayVia;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addCustomParam($name, $value)
    {
        $this->customParams['ik_x_' . $name] = $value;
    }

    public function hasCustomParam($name)
    {
        return isset($this->customParams['ik_x_' . $name]);
    }

    public function getCustomParam($name)
    {
        if ($this->hasCustomParam($name)) {
            return $this->customParams['ik_x_' . $name];
        }

        return null;
    }

    public function getCustomParams()
    {
        return $this->customParams;
    }
}
