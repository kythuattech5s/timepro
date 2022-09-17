<?php
return [
    'vouchers' => [
        'view' => [
            'add' => [
                'class' => '\Tech5s\Promotion\Controllers\VoucherController',
                'method' => 'showFormAddVoucher',
            ],
            'edit' => [
                'class' => '\Tech5s\Promotion\Controllers\VoucherController',
                'method' => 'editFormVoucher',
            ],
            'copy' => [
                'class' => '\Tech5s\Promotion\Controllers\VoucherController',
                'method' => 'copyFormVoucher',
            ],
        ],
    ],
    'combos' => [
        'view' => [
            'add' => [
                'class' => '\Tech5s\Promotion\Controllers\ComboController',
                'method' => 'showFormAdd',
            ],
            'edit' => [
                'class' => '\Tech5s\Promotion\Controllers\ComboController',
                'method' => 'showFormEdit',
            ],
            'copy' => [
                'class' => '\Tech5s\Promotion\Controllers\ComboController',
                'method' => 'showFormCopy',
            ],
        ],
    ],
    'flash_sales' => [
        'view' => [
            'add' => [
                'class' => '\Tech5s\Promotion\Controllers\FlashSaleController',
                'method' => 'showFormAdd',
            ],
            'edit' => [
                'class' => '\Tech5s\Promotion\Controllers\FlashSaleController',
                'method' => 'showFormEdit',
            ],
            'copy' => [
                'class' => '\Tech5s\Promotion\Controllers\FlashSaleController',
                'method' => 'showFormCopy',
            ],
        ],
    ],
    'deals' => [
        'view' => [
            'add' => [
                'class' => '\Tech5s\Promotion\Controllers\DealController',
                'method' => 'showFormAdd',
            ],
            'edit' => [
                'class' => '\Tech5s\Promotion\Controllers\DealController',
                'method' => 'showFormEdit',
            ],
            'copy' => [
                'class' => '\Tech5s\Promotion\Controllers\DealController',
                'method' => 'showFormCopy',
            ],
        ],
    ],
    'promotion_products' => [
        'view' => [
            'add' => [
                'class' => '\Tech5s\Promotion\Controllers\PromotionProductController',
                'method' => 'formAdd',
            ],
            'edit' => [
                'class' => '\Tech5s\Promotion\Controllers\PromotionProductController',
                'method' => 'show',
            ],
            'copy' => [
                'class' => '\Tech5s\Promotion\Controllers\PromotionProductController',
                'method' => 'copy',
            ],
        ],
    ],
];
