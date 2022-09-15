<?php

use Roniejisa\Helpers\Providers\HelperServiceProvider;

return [
    'providers' => [
        HelperServiceProvider::class
    ],

    'aliases' => [
        'CommentHelper' => Roniejisa\Comment\Helpers\Helper::class,
    ],

    'listeners' => [
        Roniejisa\Comment\Listeners\CommentListener::class,
    ],
];
