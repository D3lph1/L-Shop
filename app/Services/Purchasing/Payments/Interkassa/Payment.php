<?php
declare(strict_types=1);

namespace App\Services\Purchasing\Payments\Interkassa;

class Payment
{
    /**
     * @var int Payment number
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
     * @var \DateTimeImmutable
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
     * @param int   $number Payment number
     * @param float $amount Amount of payment
     */
    public function __construct(int $number, float $amount)
    {
        $this->number = $number;
        $this->amount = $amount;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getAmountType(): ?string
    {
        return $this->amountType;
    }

    public function setAmountType(string $amountType): self
    {
        $this->amountType = $amountType;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExpired(): ?\DateTimeImmutable
    {
        return $this->expired;
    }

    public function setExpired(\DateTimeImmutable $expired): self
    {
        $this->expired = $expired;

        return $this;
    }

    public function getLifetime(): ?int
    {
        return $this->lifetime;
    }

    public function setLifetime(int $lifetime): self
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    public function getPaywayOn(): array
    {
        return $this->paywayOn;
    }

    public function setPaywayOn(array $paywayOn): self
    {
        $this->paywayOn = $paywayOn;

        return $this;
    }

    public function getPaywayOff(): array
    {
        return $this->paywayOff;
    }

    public function setPaywayOff(array $paywayOff): self
    {
        $this->paywayOff = $paywayOff;

        return $this;
    }

    public function getPaywayVia(): array
    {
        return $this->paywayVia;
    }

    public function setPaywayVia(array $paywayVia): self
    {
        $this->paywayVia = $paywayVia;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function addCustomParam(string $name, string $value): void
    {
        $this->customParams['ik_x_' . $name] = $value;
    }

    public function hasCustomParam(string $name): bool
    {
        return isset($this->customParams['ik_x_' . $name]);
    }

    public function getCustomParam(string $name): ?string
    {
        if ($this->hasCustomParam($name)) {
            return $this->customParams['ik_x_' . $name];
        }

        return null;
    }

    public function getCustomParams(): array
    {
        return $this->customParams;
    }
}
