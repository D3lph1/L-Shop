<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Infrastructure\Response;

use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Success;
use App\Services\Notification\Notifications\Warning;
use App\Services\Response\JsonResponse;
use Tests\TestCase;

class JsonResponseTest extends TestCase
{
    public function testSimple()
    {
        $response = new JsonResponse('success');
        $expected = [
            'status' => 'success',
            'httpStatus' => 200,
            'notifications' => [],
        ];
        self::assertEquals($expected, $response->jsonSerialize());
    }

    public function testWithData()
    {
        $response = (new JsonResponse('fail', [
            'key1' => 'value1',
            'key2' => [
                'item1',
                'item2'
            ]
        ]))->setHttpStatus(500);
        $expected = [
            'status' => 'fail',
            'httpStatus' => 500,
            'key1' => 'value1',
            'key2' => [
                'item1',
                'item2'
            ],
            'notifications' => []
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
            'httpStatus' => 200,
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
        $response->addNotification(new Error('lorem ipsum2'));
        $expected = [
            'status' => 'success',
            'httpStatus' => 200,
            'key' => 1,
            'notifications' => [
                [
                    'type' => 'warning',
                    'content' => 'lorem ipsum1'
                ],
                [
                    'type' => 'error',
                    'content' => 'lorem ipsum2'
                ]
            ]
        ];
        self::assertEquals($expected, $response->jsonSerialize());
    }
}
