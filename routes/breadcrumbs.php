<?php
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', VRoute::get('home'));
});
Breadcrumbs::for('static', function ($trail,$name,$link) {
    $trail->parent('home');
    $trail->push($name,$link);
});
Breadcrumbs::for('pages', function ($trail, $currentItem) {
    $trail->parent('home');
    $trail->push(\Support::show($currentItem,'name'), \Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('news_category', function ($trail, $currentItem, $level = 0) {
	if ($level == 0) {
		$trail->parent('home');
	}
	if ($currentItem->parent > 0) {
		$parent = App\Models\NewsCategory::where('news_categories.id',\Support::show($currentItem,'parent'))->first();
	    if ($parent != null) {
    		$trail->parent('news_category', $parent, $level += 1);
	    }	
	}
    $trail->push(\Support::show($currentItem, 'name'), \Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('news', function ($trail, $currentItem, $parent) {
    if ($parent == null) {
		$trail->parent('home');
   		$trail->push(\Support::show($currentItem,'name'), \Support::show($currentItem, 'slug'));
    }
    else{
    	$trail->parent('news_category', $parent);
    	$trail->push(\Support::show($currentItem,'name'), \Support::show($currentItem, 'slug'));
    }
});

Breadcrumbs::for('course_category', function ($trail, $currentItem, $level = 0) {
	if ($level == 0) {
		$trail->parent('home');
	}
	if ($currentItem->parent > 0) {
		$parent = App\Models\CourseCategory::where('course_categories.id',\Support::show($currentItem,'parent'))->first();
	    if ($parent != null) {
    		$trail->parent('course_category', $parent, $level += 1);
	    }	
	}
    $trail->push(\Support::show($currentItem, 'name'), \Support::show($currentItem, 'slug'));
});
Breadcrumbs::for('course', function ($trail, $currentItem, $parent) {
    if ($parent == null) {
		$trail->parent('home');
   		$trail->push(\Support::show($currentItem,'name'), \Support::show($currentItem, 'slug'));
    }
    else{
    	$trail->parent('course_category', $parent);
    	$trail->push(\Support::show($currentItem,'name'), \Support::show($currentItem, 'slug'));
    }
});
