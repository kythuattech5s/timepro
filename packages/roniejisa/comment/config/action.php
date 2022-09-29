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
                'model' => [
                    'fix' => true,
                    "value" => "\Roniejisa\Comment\Models\Comment",
                ],
                'parentField' => [
                    'fix' => true,
                    "value" => "comment_id",
                ],
                'nameTable' => [
                    'fix' => true,
                    "value" => "comments",
                ],
                'view' => [
                    "fix" => true,
                    "value" => "commentRS::comments.detail"
                ],
                'view_item' => [
                    "fix" => true,
                    "value" => "commentRS::comments.item"
                ]
            ],
        ],
    ],
    'question_teachers' => [
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
                'model' => [
                    'fix' => true,
                    "value" => "\App\Models\QuestionTeacher",
                ],
                'parentField' => [
                    'fix' => true,
                    "value" => "question_teacher_id",
                ],
                'nameTable' => [
                    'fix' => true,
                    "value" => "comments",
                ],
                'view' => [
                    "fix" => true,
                    "value" => "commentRS::comments.detail"
                ],
                'view_item' => [
                    "fix" => true,
                    "value" => "commentRS::comments.item"
                ],
                'plus_name' => [
                    "fix" => true,
                    "value" => 'Phạm Minh Hiếu'
                ]
            ],
        ],
    ],
    'ask_and_answers' => [
        [
            'label' => 'Xem và kích hoạt câu hổi',
            'url' => url('cmrs/source/detail-comment'),
            'icon' => 'fa fa-list',
            'class' => 'border-none text-white',
            "target_blank" => false,
            'query' => [
                'id' => [
                    'fix' => false,
                    'value' => 'id',
                ],
                'model' => [
                    'fix' => true,
                    "value" => "\App\Models\AskAndAnswer",
                ],
                'parentField' => [
                    'fix' => true,
                    "value" => "ask_and_answer_id",
                ],
                'nameTable' => [
                    'fix' => true,
                    "value" => "comments",
                ],
                'view' => [
                    "fix" => true,
                    "value" => "commentRS::comments.detail"
                ],
                'view_item' => [
                    "fix" => true,
                    "value" => "commentRS::comments.item"
                ]
            ],
        ],
    ],
];
