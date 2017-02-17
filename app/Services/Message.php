<?php

namespace App\Services;

use App\Exceptions\InvalidTypeArgumentException;

/**
 * Responsible for working with alerts
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Message
{
    /**
     * Cookie name
     *
     * @var string
     */
    private $cookieName = 'message';

    /**
     * @var int
     */
    private $lifetime = 1;

    /**
     * Cookie type and text delimiter
     *
     * @var string
     */
    private $delimiter = '::';

    /**
     * Set the blue message
     *
     * @param string $text
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function info($text)
    {
        return $this->set('info', $text);
    }

    /**
     * Set the green message
     *
     * @param string $text
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function success($text)
    {
        return $this->set('success', $text);
    }

    /**
     * Set the yellow message
     *
     * @param string $text
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function warning($text)
    {
        return $this->set('warning', $text);
    }

    /**
     * Set the red message
     *
     * @param string $text
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function danger($text)
    {
        return $this->set('danger', $text);
    }

    /**
     * Get message type from cookie
     *
     * @return null|string
     */
    public function getType()
    {
        $cookie = $this->get();

        return $cookie ? $cookie[0] : null;
    }

    /**
     * Get text message from cookie
     *
     * @return null|string
     */
    public function getText()
    {
        $cookie = $this->get();

        return $cookie ? $cookie[1] : null;
    }

    /**
     * Get and explode cookie value
     *
     * @return null|array
     */
    private function get()
    {
        $cookie = \Cookie::get($this->cookieName);

        if ($cookie) {
            return explode($this->delimiter, $cookie);
        }

        return null;
    }

    /**
     * Set cookie with flash message
     *
     * @param string $type
     * @param string $text
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    private function set($type, $text)
    {
        return \Cookie::make($this->cookieName, $type . $this->delimiter . $text, $this->lifetime, '/', null, false, false);
    }

    /**
     * @return string
     */
    public function getCookieName()
    {
        return $this->cookieName;
    }

    /**
     * @param string $cookieName
     */
    public function setCookieName($cookieName)
    {
        if (is_string($cookieName)) {
            $this->cookieName = $cookieName;
        }

        throw new InvalidTypeArgumentException('string', $cookieName);
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
     */
    public function setLifetime($lifetime)
    {
        if (is_int($lifetime)) {
            $this->lifetime = $lifetime;
        }

        throw new InvalidTypeArgumentException('integer', $lifetime);
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        if (is_string($delimiter)) {
            $this->delimiter = $delimiter;
        }

        throw new InvalidTypeArgumentException('string', $delimiter);
    }
}
