<?php

namespace Tests\Feature\Admin\Info;

use Tests\Feature\Future;

/**
 * Class DocsTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Info
 */
class DocsTest extends Future
{
    /** Docs menu */
    public function testVisitAdminMenu()
    {
        $this->visitAdmin('admin.info.docs', ['server' => 1], 200);
    }

    public function testVisitUserMenu()
    {
        $this->visitUser('admin.info.docs', ['server' => 1], 403);
    }

    public function testVisitGuestMenu()
    {
        $this->visitGuest('admin.info.docs', ['server' => 1], 403);
    }

    /** Main docs */
    public function testVisitAdminMain()
    {
        $this->visitAdmin('admin.info.docs.main', ['server' => 1], 200);
    }

    public function testVisitUserMain()
    {
        $this->visitUser('admin.info.docs.main', ['server' => 1], 403);
    }

    public function testVisitGuestMain()
    {
        $this->visitGuest('admin.info.docs.main', ['server' => 1], 403);
    }

    /** API docs */
    public function testVisitAdminApi()
    {
        $this->visitAdmin('admin.info.docs.api', ['server' => 1], 200);
    }

    public function testVisitUserApi()
    {
        $this->visitUser('admin.info.docs.api', ['server' => 1], 403);
    }

    public function testVisitGuestApi()
    {
        $this->visitGuest('admin.info.docs.api', ['server' => 1], 403);
    }

    /** Sashok launcher integration docs */
    public function testVisitAdminSashokLauncher()
    {
        $this->visitAdmin('admin.info.docs.sashok_launcher_integration', ['server' => 1], 200);
    }

    public function testVisitUserSashokLauncher()
    {
        $this->visitUser('admin.info.docs.sashok_launcher_integration', ['server' => 1], 403);
    }

    public function testVisitGuestSashokLauncher()
    {
        $this->visitGuest('admin.info.docs.sashok_launcher_integration', ['server' => 1], 403);
    }

    /** CLI docs */
    public function testVisitAdminCli()
    {
        $this->visitAdmin('admin.info.docs.cli', ['server' => 1], 200);
    }

    public function testVisitUserCli()
    {
        $this->visitUser('admin.info.docs.cli', ['server' => 1], 403);
    }

    public function testVisitGuestCli()
    {
        $this->visitGuest('admin.info.docs.cli', ['server' => 1], 403);
    }
}
