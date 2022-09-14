<?php
return [
    'order_courses' => [
        [
            'label' => 'Chi tiết đơn hàng',
            'url' => url('esystem/view-order/order_courses'),
            'icon' => 'fa fa-eye',
            'class' => '',
            "target_blank" => false,
            "attributes" => '',
            'query' => [
                'id' => [
                    'fix' => false,
                    'value' => 'id',
                ],
            ],
            'show' => []
        ],
    ],
    'order_course_combos' => [
        [
            'label' => 'Chi tiết đơn hàng',
            'url' => url('esystem/view-order/order_course_combos'),
            'icon' => 'fa fa-eye',
            'class' => '',
            "target_blank" => false,
            "attributes" => '',
            'query' => [
                'id' => [
                    'fix' => false,
                    'value' => 'id',
                ],
            ],
            'show' => []
        ],
    ]
];