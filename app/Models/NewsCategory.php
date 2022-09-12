<?php
namespace App\Models;
class NewsCategory extends BaseModel
{
    public function getParent(){
        return $this->belongsTo(static::class,'parent','id');
    }
    public function news(){
    	return $this->belongsToMany('App\Models\News', 'news_news_category', 'news_category_id', 'news_id');
    }
}