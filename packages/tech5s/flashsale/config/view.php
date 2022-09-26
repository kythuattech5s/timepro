<?php
return [
    'flash_sales' => [
        'view' => [
            'add' => [
                'class' => '\Tech5s\FlashSale\Controllers\FlashSaleController',
                'method' => 'showFormAdd',
            ],
            'edit' => [
                'class' => '\Tech5s\FlashSale\Controllers\FlashSaleController',
                'method' => 'editForm',
            ],
            'copy' => [
                'class' => '\Tech5s\FlashSale\Controllers\FlashSaleController',
                'method' => 'copyForm',
            ],
        ],
    ],
];
