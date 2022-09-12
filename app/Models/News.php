<?php
namespace App\Models;
class News extends BaseModel
{
	protected $table = 'news';
    public function tags()
    {
    	return $this->belongsToMany(NewsTag::class, 'news_news_tag', 'news_id', 'news_tag_id')->act();
    }
    public function pivot(){
    	return $this->hasMany(NewsNewsCategory::class, 'news_id', 'id');
    }
    public function category()
    {
    	return $this->belongsToMany(NewsCategory::class);
    }
    
    public function getRelates()
    {
        $category = $this->category()->act()->first();
        if ($category == null) {
            return null;
        }
        return $category->news();
    }
    public function getRelatesCollection(){
        $relate = $this->getRelates();
        return $relate?$relate->act()->ord()->take(6)->get():collect();
    }
}