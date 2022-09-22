<?php

namespace modulevideosecurity\managevideo\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class TvsMapItem extends Model

{    

	use HasFactory;

	protected $table = 'tvs_map_items';

	public function tvsSecret()

	{

		return $this->hasOne(TvsSecret::class, 'media_id', 'video_media_map_id');

	}

}