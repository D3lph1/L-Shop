<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Infrastructure\Response;

use App\Services\Infrastructure\Notification\Notifications\Danger;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notifications\Warning;
use App\Services\Infrastructure\Response\JsonResponse;
use Tests\TestCase;

class JsonResponseTest extends TestCase
{
    public function testSimple()
    {
        $response = new JsonResponse('success');
        $expected = [
            'status' => 'success'
        ];
        self::assertEquals($expected, $response->jsonSerialize());
    }

    public function testWithData()
    {
        $response = new JsonResponse('fail', [
            'key1' => 'value1',
            'key2' => [
                'item1',
                'item2'
            ]
        ]);
        $expected = [
            'status' => 'fail',
            'key1' => 'value1',
            'key2' => [
                'item1',
                'item2'
            ]
        ];
        self::assertEquals($expected, $response->jsonSerialize());
    }

    public function testWithNotifications()
    {
        $response = new JsonResponse('success');
        $response->addNotification(new Success('lorem ipsum1'));
        $response->addNotification(new Success('lorem ipsum2'));
        $expected = [
            'status' => 'success',
            'notifications' => [
                [
                    'type' => 'success',
                    'content' => 'lorem ipsum1'
                ],
                [
                    'type' => 'success',
                    'content' => 'lorem ipsum2'
                ]
            ]
        ];
        self::assertEquals($expected, $response->jsonSerialize());
    }

    public function testWithDataAndNotifications()
    {
        $response = new JsonResponse('success', ['key' => 1]);
        $response->addNotification(new Warning('lorem ipsum1'));
        $response->addNotification(new Danger('lorem ipsum2'));
        $expected = [
            'status' => 'success',
            'key' => 1,
            'notifications' => [
                [
                    'type' => 'warning',
                    'content' => 'lorem ipsum1'
                ],
                [
                    'type' => 'danger',
                    'content' => 'lorem ipsum2'
                ]
            ]
        ];
        self::assertEquals($expected, $response->jsonSerialize());
    }
}
