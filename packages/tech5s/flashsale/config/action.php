<?php
return [
    'flash_sales' => [
        [
            'label' => 'Thêm khóa học',
            'url' => url('tpf/flashsale/chinh-sua-chi-tiet-flash-sale'),
            'icon' => 'fa fa-plus',
            'class' => '',
            "target_blank" => false, // Không bắt buộc
            "attributes" => 'modal-target="#test"', // Không bắt buộc - nếu là modal thì có thể thêm view modal tại component
            'query' => [
                'id' => [
                    'fix' => false,
                    'value' => 'id',
                ],
            ],
            'show' => [ //không bắt buộc

            ]
        ],
    ]
];
