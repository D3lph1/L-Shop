<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Settings;

use App\Services\Settings\DefaultSettings;
use App\Services\Settings\Driver;
use App\Services\Settings\Repository\MemoryRepository;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    public function test(): void
    {
        $settings = new DefaultSettings(new Driver(new MemoryRepository()));
        $settings->set('lorem1', 'ipsum1');
        $settings->set('lorem2', 'ipsum2');
        $settings->set('lorem3', 'ipsum3');
        $settings->save();

        self::assertEquals('ipsum1', $settings->get('lorem1')->getValue());
        self::assertNull($settings->get('lorem1')->getUpdatedAt());
        self::assertEquals('ipsum2', $settings->get('lorem2')->getValue());
        self::assertNull($settings->get('lorem2')->getUpdatedAt());
        self::assertEquals('ipsum3', $settings->get('lorem3')->getValue());
        self::assertNull($settings->get('lorem3')->getUpdatedAt());

        $settings->get('lorem1')->setValue('test');
        $settings->save();
        self::assertEquals('test', $settings->get('lorem1')->getValue());

        $settings->forget('lorem2');
        $settings->save();

        self::assertNotNull($settings->get('lorem1'));
        self::assertNull($settings->get('lorem2'));
        self::assertNotNull($settings->get('lorem3'));

        $settings->flush();
        $settings->save();

        self::assertNull($settings->get('lorem1'));
        self::assertNull($settings->get('lorem2'));
        self::assertNull($settings->get('lorem3'));
    }
}
