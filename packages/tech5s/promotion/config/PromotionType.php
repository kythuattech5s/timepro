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
            'view' => 'tp::flash_sales.components.types.category',
            'search_view' => 'tp::flash_sales.components.SearchCategory',
        ],
        $keys['ALL'] => [
            'view' => 'tp::flash_sales.components.types.all',
            'search_view' => 'tp::flash_sales.components.All',
        ],

    ],
];
