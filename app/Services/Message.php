<?php

namespace App\Services;

use App\Exceptions\InvalidArgumentTypeException;

/**
 * Responsible for working with alert messages
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Message
{
    public function info($text)
    {
        $this->set('info', $text);
    }

    public function success($text)
    {
        $this->set('success', $text);
    }

    public function warning($text)
    {
        $this->set('warning', $text);
    }

    public function danger($text)
    {
        $this->set('danger', $text);
    }

    public function get()
    {
        $data = (array)\Session::get('message');
        $this->clear();

        return $data;
    }

    private function set($type, $text)
    {
        $data = [
            'type' => $type,
            'text' => $text
        ];

        \Session::push('message', $data);
    }

    private function clear()
    {
        \Session::remove('message');
    }
}
