<?php

namespace App\Services\PaymentAssistant\Invoices;

use App\Services\PaymentAssistant\Invoice;

class Robokassa extends Invoice
{
    const LANG_RU = 'ru';
    const LANG_EN = 'en';

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $encoding = 'utf-8';

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return $this
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }
}