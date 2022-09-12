<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class NewsNewsCategory extends BaseModel
{
    use HasFactory;
    protected $table = 'news_news_category';
    public function newsCategory()
    {
    	return $this->belongsTo('App\Models\NewsCategory', 'news_category_id', 'id');
    }
}