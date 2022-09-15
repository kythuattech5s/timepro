<?php

namespace Roniejisa\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Roniejisa\Comment\Traits\GetDataComment;

class Product extends Model
{
    use HasFactory, GetDataComment;
}
