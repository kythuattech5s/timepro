<?php

return [
    'comments' => [
        [
            'label' => 'Xem và kích hoạt bình luận',
            'url' => url('cmrs/source/detail-comment'),
            'icon' => 'fa fa-list',
            'class' => 'border-none text-white',
            "target_blank" => false,
            'query' => [
                'id' => [
                    'fix' => false,
                    'value' => 'id',
                ],
            ],
        ],
    ],
];
