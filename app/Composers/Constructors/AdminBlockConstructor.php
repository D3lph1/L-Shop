<?php
declare(strict_types = 1);

namespace App\Composers\Constructors;

class AdminBlockConstructor
{
    public function construct(): array
    {
        return [
            [
                'caption' => __('sidebar.admin.control.name'),
                'icon' => 'cogs',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.control.nodes.main_settings')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.control.nodes.payments')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.control.nodes.api')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.control.nodes.security')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.control.nodes.optimization')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.servers.name'),
                'icon' => 'server',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.servers.nodes.add')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.servers.nodes.edit')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.products.name'),
                'icon' => 'cubes',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.products.nodes.add')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.products.nodes.edit')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.items.name'),
                'icon' => 'diamond',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.items.nodes.add')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.items.nodes.edit')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.news.name'),
                'icon' => 'newspaper-o',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.news.nodes.add')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.news.nodes.edit')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.pages.name'),
                'icon' => 'files-o',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.pages.nodes.add')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.pages.nodes.edit')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.users.name'),
                'icon' => 'users',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.users.nodes.edit')
                    ]
                ]
            ],
            [
                'caption' => __('sidebar.admin.other.name'),
                'icon' => 'ellipsis-h',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.other.nodes.rcon')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.other.nodes.debug')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.statistic.name'),
                'icon' => 'pencil',
                'subItems' => [
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.statistic.nodes.show')
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.statistic.nodes.payments')
                    ],
                ]
            ],
            [
                'caption' => __('sidebar.admin.info.name'),
                'icon' => 'info',
                'subItems' => [
                    [
                        'link' => 'https://github.com/D3lph1/L-shop/wiki',
                        'caption' => __('sidebar.admin.info.nodes.docs'),
                        'target' => '_blank'
                    ],
                    [
                        'link' => '',
                        'caption' => __('sidebar.admin.info.nodes.about')
                    ],
                ]
            ]
        ];
    }
}
