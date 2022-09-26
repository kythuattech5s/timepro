<?php

namespace Roniejisa\Comment\Traits;

use Roniejisa\Comment\Models\Comment;
use Roniejisa\Comment\Models\Rating;

trait GetDataComment
{
    public function getPercent($default = '0%')
    {
        if ($this->info_rating !== null && ($rating = json_decode($this->info_rating, true)) !== null) {
            return $rating['percentAll'] . '%';
        }
        return $default;
    }

    public function getRating(String $type = 'default', $noCalculator = true)
    {
        if ($type == 'default' && $noCalculator && isset($this->info_rating)) {
            if (json_decode($this->info_rating, true) == null) {
                return [
                    'oneStar' => 0,
                    'twoStar' => 0,
                    'threeStar' => 0,
                    'fourStar' => 0,
                    'fiveStar' => 0,
                    'percentOneStar' => 0,
                    'percentTwoStar' => 0,
                    'percentThreeStar' => 0,
                    'percentFourStar' => 0,
                    'percentFiveStar' => 0,
                    'totalRating' => 0,
                    'percentAll' => 0,
                    'scoreAll' => 0,
                    'typePercent' => '',
                ];
            } else {
                return json_decode($this->info_rating, true);
            }
        }

        $typePercent = '';
        $ratings = $this->ratings;
        $oneStar = 0;
        $twoStar = 0;
        $threeStar = 0;
        $fourStar = 0;
        $fiveStar = 0;
        $percentOneStar = 0;
        $percentTwoStar = 0;
        $percentThreeStar = 0;
        $percentFourStar = 0;
        $percentFiveStar = 0;
        $totalRating = $ratings->count();
        $percentAll = 0;
        $scoreAll = 0;
        if ($totalRating == 0) {
            if ($type == 'fake') {
                return [
                    'percentAll' => 100,
                    'scoreAll' => 5,
                    'totalRating' => 1,
                    'typePercent' => 'Rất tốt',
                ];
            }
            return [
                'oneStar' => 0,
                'twoStar' => 0,
                'threeStar' => 0,
                'fourStar' => 0,
                'fiveStar' => 0,
                'percentOneStar' => 0,
                'percentTwoStar' => 0,
                'percentThreeStar' => 0,
                'percentFourStar' => 0,
                'percentFiveStar' => 0,
                'totalRating' => 0,
                'percentAll' => 0,
                'scoreAll' => 0,
                'typePercent' => $typePercent,
            ];
        }
        $oneStar = $ratings->filter(function ($value, $key) {
            return (int) $value->rating === 1;
        })->count();
        $twoStar = $ratings->filter(function ($value, $key) {
            return (int) $value->rating === 2;
        })->count();
        $threeStar = $ratings->filter(function ($value, $key) {
            return (int) $value->rating === 3;
        })->count();
        $fourStar = $ratings->filter(function ($value, $key) {
            return (int) $value->rating === 4;
        })->count();
        $fiveStar = $ratings->filter(function ($value, $key) {
            return (int) $value->rating === 5;
        })->count();
        $percentAll = round(($oneStar + $twoStar * 2 + $threeStar * 3 + $fourStar * 4 + $fiveStar * 5) / ($totalRating * 5) * 100);
        $scoreAll = round($percentAll / 20, 2);
        $typePercent = self::labelRating($scoreAll);
        if ($type == 'main') {
            return [
                'percentAll' => $percentAll,
                'scoreAll' => $scoreAll,
                'totalRating' => $totalRating,
                'typePercent' => $typePercent,
            ];
        }
        $percentOneStar = round($oneStar / $totalRating * 100);
        $percentTwoStar = round($twoStar / $totalRating * 100);
        $percentThreeStar = round($threeStar / $totalRating * 100);
        $percentFourStar = round($fourStar / $totalRating * 100);
        $percentFiveStar = round($fiveStar / $totalRating * 100);

        $dataRatingInfo = [
            'oneStar' => $oneStar,
            'twoStar' => $twoStar,
            'threeStar' => $threeStar,
            'fourStar' => $fourStar,
            'fiveStar' => $fiveStar,
            'percentOneStar' => $percentOneStar,
            'percentTwoStar' => $percentTwoStar,
            'percentThreeStar' => $percentThreeStar,
            'percentFourStar' => $percentFourStar,
            'percentFiveStar' => $percentFiveStar,
            'totalRating' => $totalRating,
            'percentAll' => $percentAll,
            'scoreAll' => $scoreAll,
            'typePercent' => $typePercent,
        ];

        return $type == 'add' ? json_encode($dataRatingInfo, JSON_UNESCAPED_UNICODE) : $dataRatingInfo;
    }

    public static function labelRating($scoreAll)
    {
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

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'map_id', 'id')->where('act', 1)->where('map_table', $this->getTable());
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'map_id', 'id')->with('rating', 'user')->where('act', 1)->where('map_table', $this->getTable())->where('comment_id', null);
    }

    public function commentTeacher()
    {
        return $this->hasMany(Comment::class,'map_id','id')->where('map_table','users');
    }
}
