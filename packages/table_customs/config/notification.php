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
      ],
      [
        'field' => 'comment_id',
        'operator' => '=',
        'value' => null
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
      ],
      [
        'field' => 'question_teacher_id',
        'operator' => '=',
        'value' => null
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
    'select' => ['id', 'order_status_id'],
    "where" => [
      [
        'field' => 'order_status_id',
        'operator' => '=',
        'value' => 1
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
