<?php

use Tech5s\Promotion\Helpers\ComboHelper;
use Tech5s\Promotion\Helpers\DealHelper;
use Tech5s\Promotion\Helpers\FlashSaleHelper;
use Tech5s\Promotion\Helpers\VoucherHelper;
use Tech5s\Promotion\Listeners\PromotionListener;

return [
    'providers' => [
    ],

    'aliases' => [
        'FlashSaleHelper' => FlashSaleHelper::class,
        'VoucherHelper' => VoucherHelper::class,
        'ComboHelper' => ComboHelper::class,
        'DealHelper' => DealHelper::class,
        'PromotionHelper' => PromotionHelper::class,
    ],
    'listeners' => [
        PromotionListener::class,
    ],
]

?>
