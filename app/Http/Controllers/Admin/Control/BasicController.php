<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Control;

use App\Handlers\Admin\Control\Basic\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Control\SaveBasicSettingsRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\Settings;

class BasicController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_CONTROL_BASIC_ACCESS));
    }

    public function render(VisitHandler $handler): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS, $handler->handle());
    }

    public function save(SaveBasicSettingsRequest $request, Settings $settings): JsonResponse
    {
        $settings->setArray([
            'shop' => [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'keywords' => json_encode($request->get('keywords')),
            ],
            'auth' => [
                'access_mode' => $request->get('access_mode'),
                'register' => [
                    'enabled' => (bool)$request->get('register_enabled'),
                    'send_activation' => (bool)$request->get('send_activation_enabled'),
                    'custom_redirect' => [
                        'enabled' => (bool)$request->get('custom_redirect_enabled'),
                        'url' => $request->get('custom_redirect_url'),
                    ]
                ]
            ],
            'system' => [
                'profile' => [
                    'character' => [
                        'skin' => [
                            'enabled' => (bool)$request->get('skin_enabled'),
                            'max_file_size' => (int)$request->get('skin_max_file_size'),
                            'list' => json_encode($request->get('skin_list')),
                            'hd' => [
                                'enabled' => $request->get('skin_hd_enabled'),
                                'list' => json_encode($request->get('skin_hd_list'))
                            ]
                        ],
                        'cloak' => [
                            'enabled' => (bool)$request->get('cloak_enabled'),
                            'max_file_size' => (int)$request->get('cloak_max_file_size'),
                            'list' => json_encode($request->get('cloak_list')),
                            'hd' => [
                                'enabled' => $request->get('cloak_hd_enabled'),
                                'list' => json_encode($request->get('cloak_hd_list'))
                            ]
                        ],
                    ]
                ],
                'catalog' => [
                    'pagination' => [
                        'per_page' => (int)$request->get('catalog_per_page'),
                        'order_by' => $request->get('sort_products_by'),
                        'descending' => (bool)$request->get('sort_products_descending')
                    ]
                ],
                'news' => [
                    'enabled' => (bool)$request->get('news_enabled'),
                    'pagination' => [
                        'per_page' => (int)$request->get('news_per_portion')
                    ]
                ],
                'monitoring' => [
                    'enabled' => (bool)$request->get('monitoring_enabled'),
                    'rcon' => [
                        'timeout' => (int)$request->get('monitoring_rcon_timeout'),
                        'command' => $request->get('monitoring_rcon_command'),
                        'pattern' => $request->get('monitoring_rcon_response_pattern')
                    ]
                ]
            ]
        ]);
        $settings->save();

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('common.changed')));
    }
}
