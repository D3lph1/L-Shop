<?php
declare(strict_types = 1);

namespace App\Composers\Constructors;

use App\Exceptions\UnexpectedValueException;
use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;
use App\Services\Meta\System;
use App\Services\Security\Accessors\Accessor;
use Illuminate\Contracts\Container\Container;

class AdminBlockConstructor
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $items;

    public function __construct(Auth $auth, Container $container)
    {
        $this->auth = $auth;
        $this->container = $container;
        $this->items = [
            [
                'title' => __('content.layout.shop.sidebar.admin.control.title'),
                'icon' => 'settings_applications',
                'subItems' => [
                    [
                        'link' => 'admin.control.basic',
                        'title' => __('content.layout.shop.sidebar.admin.control.sub_items.main_settings'),
                        'permissions' => [Permissions::ADMIN_CONTROL_BASIC_ACCESS]
                    ],
                    [
                        'link' => 'admin.control.payments',
                        'title' => __('content.layout.shop.sidebar.admin.control.sub_items.payments'),
                        'permissions' => [Permissions::ADMIN_CONTROL_PAYMENTS_ACCESS]
                    ],
                    [
                        'link' => 'admin.control.api',
                        'title' => __('content.layout.shop.sidebar.admin.control.sub_items.api'),
                        'permissions' => [Permissions::ADMIN_CONTROL_API_ACCESS]
                    ],
                    [
                        'link' => 'admin.control.security',
                        'title' => __('content.layout.shop.sidebar.admin.control.sub_items.security'),
                        'permissions' => [Permissions::ADMIN_CONTROL_SECURITY_ACCESS]
                    ],
                    [
                        'link' => 'admin.control.optimization',
                        'title' => __('content.layout.shop.sidebar.admin.control.sub_items.optimization'),
                        'permissions' => [Permissions::ADMIN_CONTROL_OPTIMIZATION_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.servers.title'),
                'icon' => 'storage',
                'subItems' => [
                    [
                        'link' => '',
                        'title' => __('content.layout.shop.sidebar.admin.servers.sub_items.add'),
                        'permissions' => [Permissions::ADMIN_SERVERS_CRUD_ACCESS]
                    ],
                    [
                        'link' => '',
                        'title' => __('content.layout.shop.sidebar.admin.servers.sub_items.edit'),
                        'permissions' => [Permissions::ADMIN_SERVERS_CRUD_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.products.title'),
                'icon' => 'apps',
                'subItems' => [
                    [
                        'link' => 'admin.products.add',
                        'title' => __('content.layout.shop.sidebar.admin.products.sub_items.add'),
                        'permissions' => [Permissions::ADMIN_PRODUCTS_CRUD_ACCESS]
                    ],
                    [
                        'link' => 'admin.products.list',
                        'title' => __('content.layout.shop.sidebar.admin.products.sub_items.edit'),
                        'permissions' => [Permissions::ADMIN_PRODUCTS_CRUD_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.items.title'),
                'icon' => 'beach_access',
                'subItems' => [
                    [
                        'link' => 'admin.items.add',
                        'title' => __('content.layout.shop.sidebar.admin.items.sub_items.add'),
                        'permissions' => [Permissions::ADMIN_ITEMS_CRUD_ACCESS]
                    ],
                    [
                        'link' => 'admin.items.list',
                        'title' => __('content.layout.shop.sidebar.admin.items.sub_items.edit'),
                        'permissions' => [Permissions::ADMIN_ITEMS_CRUD_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.news.title'),
                'icon' => 'library_books',
                'subItems' => [
                    [
                        'link' => '',
                        'title' => __('content.layout.shop.sidebar.admin.news.sub_items.add'),
                        'permissions' => [Permissions::ADMIN_NEWS_CRUD_ACCESS]
                    ],
                    [
                        'link' => 'admin.news.list',
                        'title' => __('content.layout.shop.sidebar.admin.news.sub_items.edit'),
                        'permissions' => [Permissions::ADMIN_NEWS_CRUD_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.pages.title'),
                'icon' => 'insert_drive_file',
                'subItems' => [
                    [
                        'link' => 'admin.pages.add',
                        'title' => __('content.layout.shop.sidebar.admin.pages.sub_items.add'),
                        'permissions' => [Permissions::ADMIN_PAGES_CRUD_ACCESS]
                    ],
                    [
                        'link' => 'admin.pages.list',
                        'title' => __('content.layout.shop.sidebar.admin.pages.sub_items.edit'),
                        'permissions' => [Permissions::ADMIN_PAGES_CRUD_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.users.title'),
                'icon' => 'people_outline',
                'subItems' => [
                    [
                        'link' => 'admin.users.list',
                        'title' => __('content.layout.shop.sidebar.admin.users.sub_items.edit'),
                        'permissions' => [Permissions::ADMIN_USERS_CRUD_ACCESS]
                    ]
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.other.title'),
                'icon' => 'more_horiz',
                'subItems' => [
                    [
                        'link' => 'admin.other.rcon',
                        'title' => __('content.layout.shop.sidebar.admin.other.sub_items.rcon'),
                        'permissions' => [Permissions::ADMIN_USERS_CRUD_ACCESS]
                    ],
                    [
                        'link' => 'admin.other.debug',
                        'title' => __('content.layout.shop.sidebar.admin.other.sub_items.debug'),
                        'permissions' => [Permissions::ADMIN_USERS_CRUD_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.statistic.title'),
                'icon' => 'show_chart',
                'subItems' => [
                    [
                        'link' => 'admin.statistic.show',
                        'title' => __('content.layout.shop.sidebar.admin.statistic.sub_items.show'),
                        'permissions' => [Permissions::ADMIN_STATISTIC_SHOW_ACCESS]
                    ],
                    [
                        'link' => 'admin.statistic.purchases',
                        'title' => __('content.layout.shop.sidebar.admin.statistic.sub_items.payments'),
                        'permissions' => [Permissions::ADMIN_PURCHASES_ACCESS]
                    ],
                ]
            ],
            [
                'title' => __('content.layout.shop.sidebar.admin.info.title'),
                'icon' => 'info',
                'subItems' => [
                    [
                        'link' => System::documentationUrL(),
                        'absolute' => true,
                        'title' => __('content.layout.shop.sidebar.admin.info.sub_items.docs'),
                        'target' => '_blank',
                        'permissions' => [Permissions::ADMIN_INFORMATION_ABOUT_ACCESS]
                    ],
                    [
                        'link' => 'admin.information.about',
                        'title' => __('content.layout.shop.sidebar.admin.info.sub_items.about'),
                        'permissions' => [Permissions::ADMIN_INFORMATION_ABOUT_ACCESS]
                    ],
                ]
            ]
        ];
    }

    public function construct(): array
    {
        if (!$this->auth->check()) {
            return [];
        }

        foreach ($this->items as $k => &$item) {
            foreach ($item['subItems'] as $key => &$subItem) {
                if (isset($subItem['permissions'])) {
                    if (!$this->allowed($subItem)) {
                        unset($item['subItems'][$key]);
                    }
                }
            }

            if (count($item['subItems']) === 0) {
                unset($this->items[$k]);
            }
        }

        return array_values($this->items);
    }

    public function allowed(array $subItem): bool
    {
        if (isset($subItem['permissions'])) {
            if (!$this->auth->getUser()->hasAllPermissions($subItem['permissions'])) {
                return false;
            }
        }

        if (isset($subItem['accessors'])) {
            foreach ($subItem['accessors'] as $accessor) {
                if (is_object($accessor)) {
                    $instance = $accessor;
                } else {
                    /** @var Accessor $instance */
                    $instance = $this->container->make($accessor);
                }
                if (!($instance instanceof Accessor)) {
                    throw new UnexpectedValueException(
                        "Accessor {$accessor} must be implements interface App\Services\Security\Accessors\Accessor"
                    );
                }

                if (!$instance->resolve()) {
                    return false;
                }
            }
        }

        return true;
    }
}
