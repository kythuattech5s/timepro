<?php

return [
    'comments' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [
                    [
                        'field' => 'comment_id',
                        'operator', '=',
                        'value' => null,
                    ],
                ],
            ],
        ],
    ],
]
?>
