<?php

namespace App\DataTransferObjects\Admin;

class Server
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var Category[]
     */
    private $categories;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $monitoringEnabled;

    /**
     * Server constructor.
     *
     * @param string     $name
     * @param bool       $enabled
     * @param Category[] $categories
     * @param string     $ip
     * @param int        $port
     * @param string     $password
     * @param bool       $monitoringEnabled
     */
    public function __construct($name, $enabled, array $categories, $ip, $port, $password, $monitoringEnabled)
    {
        $this->name = $name;
        $this->enabled = (bool)$enabled;
        $this->categories = $categories;
        $this->ip = $ip;
        $this->port = (int)$port;
        $this->password = $password;
        $this->monitoringEnabled = (bool)$monitoringEnabled;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isMonitoringEnabled()
    {
        return $this->monitoringEnabled;
    }
}
