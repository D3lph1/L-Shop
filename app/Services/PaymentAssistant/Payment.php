<?php

namespace App\Services\PaymentAssistant;

abstract class Payment
{
    /**
     * @var string
     */
    protected $url;

    abstract public function make();

    abstract public function build($invoice);

    /**
     * @param string $url
     * @throws \InvalidArgumentException
     */
    public function setUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $this->url = $url;
        }

        throw new \InvalidArgumentException("$url is a not valid url");
    }
}
