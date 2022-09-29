<?php
namespace modulevideosecurity\managevideo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvsSecret extends Model
{    
	use HasFactory;
	const CONVERTED_WAIT = 0;
	const CONVERTED_START = 1;
	const CONVERTED_COMPLETE = 2;
	const CONVERTED_FAIL = 3;
	protected $table = 'tvs_secrets';
}