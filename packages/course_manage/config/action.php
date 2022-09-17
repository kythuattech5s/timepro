<?php
return [
    'orders' => [
        [
            'label' => 'Chi tiết đơn hàng',
            'url' => url('esystem/view-order/orders'),
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