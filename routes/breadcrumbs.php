<?php
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', VRoute::get('home'));
});
Breadcrumbs::for('static', function ($trail,$name,$link) {
    $trail->parent('home');
    $trail->push($name,$link);
});