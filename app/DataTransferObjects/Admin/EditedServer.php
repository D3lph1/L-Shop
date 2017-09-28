<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin;

use App\Models\Server\ServerInterface;

/**
 * Class EditedServer
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects\Admin
 */
class EditedServer
{
    /**
     * @var ServerInterface
     */
    private $server;

    /**
     * @var iterable
     */
    private $categories;

    public function setServer(ServerInterface $server): self
    {
        $this->server = $server;

        return $this;
    }

    public function getServer(): ServerInterface
    {
        return $this->server;
    }

    public function setCategories(iterable $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getCategories(): iterable
    {
        return $this->categories;
    }
}
