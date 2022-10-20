<?php

return [
    [
        "link" => "view/comments",
        'select' => ['id', 'is_read'],
        "where" => [
            [
                'field' => 'is_read',
                'operator' => '=',
                'value' => 0
            ]
        ],
        'table' => 'comments',
    ],
    [
        "link" => "view/question_teachers",
        'select' => ['id', 'is_read'],
        "where" => [
            [
                'field' => 'is_read',
                'operator' => '=',
                'value' => 0
            ]
        ],
        'table' => 'question_teachers',
    ],
    [
        "link" => "view/ask_and_answers",
        'select' => ['id', 'is_read'],
        "where" => [
            [
                'field' => 'is_read',
                'operator' => '=',
                'value' => 0
            ]
        ],
        'table' => 'ask_and_answers',
    ],
    [
        "link" => "view/orders",
        'select' => ['id', 'admin_confirm_id'],
        "where" => [
            [
                'field' => 'admin_confirm_id',
                'operator' => '=',
                'value' => 0
            ]
        ],
        'table' => 'orders',
    ],
    [
        "link" => "view/contacts",
        'select' => ['id', 'is_read'],
        "where" => [
            [
                'field' => 'is_read',
                'operator' => '=',
                'value' => 0
            ]
        ],
        'table' => 'contacts',
    ]
];
