<?php
declare(strict_types=1);

namespace Tests\Integrated\Services\Cart\Storage;

use App\Services\Cart\Storage\Session;
use Tests\TestCase;

class SessionTest extends TestCase
{
    public function test(): void
    {
        $storage = app(Session::class);
        $storage->put(2, 17, 64);
        $session = app(\Illuminate\Contracts\Session\Session::class);
        $cart = $session->get("{$storage->getKey()}");
        self::assertEquals([
            2 => [
                17 => 64
            ]
        ], $cart);
        $storage->put(2, 101, 16);
        $cart = $session->get("{$storage->getKey()}");
        self::assertEquals([
            2 => [
                17 => 64,
                101 => 16
            ]
        ], $cart);
        $storage->put(5, 12, 32);
        $cart = $session->get("{$storage->getKey()}");
        self::assertEquals([
            2 => [
                17 => 64,
                101 => 16
            ],
            5 => [
                12 => 32
            ]
        ], $cart);
        self::assertEquals([
            17 => 64,
            101 => 16
        ], $storage->retrieveServer(2));
        self::assertEquals(32, $storage->retrieve(5, 12));

        self::assertEquals(true, $storage->removeServer(5));
        $cart = $session->get("{$storage->getKey()}");
        self::assertEquals([
            2 => [
                17 => 64,
                101 => 16
            ]
        ], $cart);
        self::assertEquals(true, $storage->remove(2, 17));
        $cart = $session->get("{$storage->getKey()}");
        self::assertEquals([
            2 => [
                101 => 16
            ]
        ], $cart);
    }
}
