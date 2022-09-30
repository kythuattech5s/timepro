<?php

return [
    'comments' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [
                    [
                        'field' => 'comment_id',
                        'operator', '=',
                        'value' => null,
                    ],
                ],
            ],
        ],
    ],
    'question_teachers' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [
                    [
                        'field' => 'question_teacher_id',
                        'operator', '=',
                        'value' => null,
                    ],
                ],
            ],
        ],
    ],
    'ask_and_answers' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả',
                'name' => 'home',
                'default' => true,
                'where' => [
                    [
                        'field' => 'ask_and_answer_id',
                        'operator', '=',
                        'value' => null,
                    ],
                ],
            ],
        ],
    ],
]
?>
