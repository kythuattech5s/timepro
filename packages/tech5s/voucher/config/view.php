<?php
return [
    'vouchers' => [
        'view' => [
            'add' => [
                'class' => '\Tech5s\Voucher\Controllers\VoucherController',
                'method' => 'showFormAddVoucher',
            ],
            'edit' => [
                'class' => '\Tech5s\Voucher\Controllers\VoucherController',
                'method' => 'editFormVoucher',
            ],
            'copy' => [
                'class' => '\Tech5s\Voucher\Controllers\VoucherController',
                'method' => 'copyFormVoucher',
            ],
        ],
    ],
];
