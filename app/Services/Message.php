<?php

namespace App\Services;

/**
 * BuyResponse for working with alert messages
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Message
{
    /**
     * Set the informing(blue) message
     *
     * @param string $text
     */
    public function info($text)
    {
        $this->set('info', $text);
    }

    /**
     * Set the success(green) message
     *
     * @param string $text
     */
    public function success($text)
    {
        $this->set('success', $text);
    }

    /**
     * Set the warning(yellow) message
     *
     * @param string $text
     */
    public function warning($text)
    {
        $this->set('warning', $text);
    }

    /**
     * Set the danger(red) message
     *
     * @param string $text
     */
    public function danger($text)
    {
        $this->set('danger', $text);
    }

    /**
     * Get all messages as array. And clear message storage.
     * Result structure:
     * [
     *      0 => [
     *              'type' => 'info',
     *              'text' => 'Example text...'
     *           ],
     *      1 => [
     *              'type' => 'success',
     *              'text' => 'С нами лучше не балуй, лишь бы цел остался... (c) Золтан'
     *           ],
     *      ...
     * ]
     *
     * @return array
     */
    public function get()
    {
        $data = (array)\Session::get('message');
        $this->clear();

        return $data;
    }

    /**
     * Push the message in session
     *
     * @param string $type
     * @param string $text
     */
    private function set($type, $text)
    {
        $data = [
            'type' => $type,
            'text' => $text
        ];

        \Session::push('message', $data);
    }

    /**
     * Clear all messages storage
     */
    private function clear()
    {
        \Session::remove('message');
    }
}
