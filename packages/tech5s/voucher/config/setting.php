<?php

return [
    'controller' => '\Tech5s\Voucher\Controllers',
    'route' => 'tpv',
    'table_name' => 'khóa học',
    'table' => 'courses',
    'category_table' => 'course_categories',
    'pivot_table' => 'course_course_category',
    'pivot_field_table' => 'course_id',
    'pivot_field_category_table' => 'course_category_id',
    'pivot_method' => 'courses',
    'pivot_method_categories' => 'course_categories',
    'has_pivot' => true,
];
