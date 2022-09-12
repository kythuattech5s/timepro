<?php
namespace App\Models;
class NewsTag extends BaseModel
{
    public function news(){
    	return $this->belongsToMany('App\Models\News', 'news_news_tag', 'news_tag_id', 'news_id');
    }
}