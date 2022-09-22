<?php
$keys = [
    'ALL' => 1,
    'CATEGORY' => 2,
];

return [
    'key' => $keys,
    'data' => [
        $keys['CATEGORY'] => [
            'model' => '\App\Models\CourseCategory',
            'select' => ['id', 'name'],
            'where' => [
                'act' => 1,
            ],
            'with' => [
                'course',
            ],
            'view' => 'tpf::components.types.category',
            'search_view' => 'tpf::components.SearchCategory',
        ],
        $keys['ALL'] => [
            'view' => 'tpf::components.types.all',
            'search_view' => 'tpf::components.All',
        ],

    ],
];
