<?php

namespace Roniejisa\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id')->where('act', 1);
    }

    public function getLabel()
    {
        $scoreAll = $this->rating;

        if ($scoreAll >= 4.5) {
            $typePercent = 'Rất tốt';
        } elseif ($scoreAll >= 4) {
            $typePercent = 'Tốt';
        } elseif ($scoreAll >= 3) {
            $typePercent = 'Bình thường';
        } elseif ($scoreAll >= 2) {
            $typePercent = 'Kém';
        } elseif ($scoreAll > 0) {
            $typePercent = 'Rất kém';
        } else {
            $typePercent = '';
        }

        return $typePercent;
    }
}
