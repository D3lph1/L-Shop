<?php
declare(strict_types = 1);

namespace App\Services\Payments\Robokassa;

/**
 * Class Payment
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Payments\Robokassa
 */
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCulture(): ?string
    {
        return $this->culture;
    }

    public function setCulture(string $culture): self
    {
        $this->culture = $culture;

        return $this;
    }

    public function getCurrencyLabel(): ?string
    {
        return $this->currencyLabel;
    }

    public function setCurrencyLabel(string $currencyLabel): self
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
    public function setEmail(string $email): self
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
