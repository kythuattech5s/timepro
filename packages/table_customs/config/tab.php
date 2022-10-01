<?php
use App\Models\UserType;
return [
    'users' => [
        'class' => 'CustomTable\Controllers\TabController',
        'method' => 'getDataTab',
        'tabs' => [
            [
                'label' => 'Tất cả tài khoản',
                'name' => 'all_user',
                'default' => true,
                'where' => [],
            ],
            [
                'label' => 'Tài khoản học viên',
                'name' => 'user_normal',
                'default' => false,
                'where' => [
                    [
                        'field' => 'user_type_id',
                        'operator' => '=',
                        'value' => UserType::NORMAL_ACCOUNT
                    ]
                ],
            ],
            [
                'label' => 'Tài khoản giảng viên',
                'name' => 'user_teacher',
                'default' => false,
                'where' => [
                    [
                        'field' => 'user_type_id',
                        'operator' => '=',
                        'value' => UserType::TEACHER_ACCOUNT
                    ],
                ]
            ],
            [
                'label' => 'Tài khoản học viên nội bộ',
                'name' => 'user_internal_student_account',
                'default' => false,
                'where' => [
                    [
                        'field' => 'user_type_id',
                        'operator' => '=',
                        'value' => UserType::INTERNAL_STUDENT_ACCOUNT
                    ]
                ],
            ]
        ],
    ],
];
