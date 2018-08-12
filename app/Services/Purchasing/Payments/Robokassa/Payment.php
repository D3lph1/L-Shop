<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Payments\Robokassa;

class Payment
{
    /**
     * @var int
     */
    protected $number;

    /**
     * @var float
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
    public function __construct(int $number, float $amount)
    {
        $this->number = $number;
        // Format as it requires robokassa.
        $this->amount = number_format($amount, 2, '.', '');
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @return string Formatted amount string.
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): Payment
    {
        $this->description = $description;
        return $this;
    }

    public function getCulture(): ?string
    {
        return $this->culture;
    }

    public function setCulture(string $culture): Payment
    {
        $this->culture = $culture;
        return $this;
    }

    public function getCurrencyLabel(): ?string
    {
        return $this->currencyLabel;
    }

    public function setCurrencyLabel(string $currencyLabel): Payment
    {
        $this->currencyLabel = $currencyLabel;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): Payment
    {
        $this->email = $email;
        return $this;
    }

    public function addCustomParam(string $name, string $value)
    {
        $this->customParams['shp_' . $name] = $value;
    }

    public function hasCustomParam(string $name): bool
    {
        return isset($this->customParams['shp_' . $name]);
    }

    public function getCustomParam(string $name): ?string
    {
        if ($this->hasCustomParam($name)) {
            return $this->customParams['shp_' . $name];
        }
        return null;
    }

    public function getCustomParams(): array
    {
        return $this->customParams;
    }
}
