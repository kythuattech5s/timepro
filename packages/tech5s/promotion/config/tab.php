<?php

return [
    'vouchers' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [],
            ],
            [
                'label' => 'Đang diễn ra',
                'name' => 'happening',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '<=',
                        'value' => new DateTime(),
                    ],
                    [
                        'field' => 'expired_at',
                        'operator' => '>=',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Sắp diễn ra',
                'name' => 'start',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '>',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Đã kết thúc',
                'name' => 'endding',
                'default' => false,
                'where' => [
                    [
                        'field' => 'expired_at',
                        'operator' => '<',
                        'value' => new DateTime(),
                    ],

                ],
            ],
        ],
    ],
    'combos' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [],
            ],
            [
                'label' => 'Đang diễn ra',
                'name' => 'happening',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '<=',
                        'value' => new DateTime(),
                    ],
                    [
                        'field' => 'expired_at',
                        'operator' => '>=',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Sắp diễn ra',
                'name' => 'start',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '>',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Đã kết thúc',
                'name' => 'endding',
                'default' => false,
                'where' => [
                    [
                        'field' => 'expired_at',
                        'operator' => '<',
                        'value' => new DateTime(),
                    ],

                ],
            ],
        ],
    ],
    'flash_sales' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [],
            ],
            [
                'label' => 'Đang diễn ra',
                'name' => 'happening',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '<=',
                        'value' => new DateTime(),
                    ],
                    [
                        'field' => 'expired_at',
                        'operator' => '>=',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Sắp diễn ra',
                'name' => 'start',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '>',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Đã kết thúc',
                'name' => 'endding',
                'default' => false,
                'where' => [
                    [
                        'field' => 'expired_at',
                        'operator' => '<',
                        'value' => new DateTime(),
                    ],

                ],
            ],
        ],
    ],
    'deals' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [],
            ],
            [
                'label' => 'Đang diễn ra',
                'name' => 'happening',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '<=',
                        'value' => new DateTime(),
                    ],
                    [
                        'field' => 'expired_at',
                        'operator' => '>=',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Sắp diễn ra',
                'name' => 'start',
                'default' => false,
                'where' => [
                    [
                        'field' => 'start_at',
                        'operator' => '>',
                        'value' => new DateTime(),
                    ],

                ],
            ],
            [
                'label' => 'Đã kết thúc',
                'name' => 'endding',
                'default' => false,
                'where' => [
                    [
                        'field' => 'expired_at',
                        'operator' => '<',
                        'value' => new DateTime(),
                    ],

                ],
            ],
        ],
    ],
];
