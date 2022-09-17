<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Roniejisa\Comment\Traits\GetDataComment;
use Tech5s\VideoChapter\Traits\VideoSouceTrait;

class Course extends BaseModel
{
    use HasFactory, VideoSouceTrait, GetDataComment;
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
    public function pivot()
    {
        return $this->hasMany(CourseCourseCategory::class, 'course_id', 'id');
    }
    public function category()
    {
        return $this->belongsToMany(CourseCategory::class);
    }
    public function timePackage()
    {
        return $this->hasMany(CourseTimePackage::class);
    }
    public function userCourse()
    {
        return $this->hasMany(UserCourse::class);
    }
    public function isFree()
    {
        return $this->timePackage->count() == 0;
    }
    public function scopeBaseView($q)
    {
        return $q->act()->with(['teacher' => function ($q) {
            $q->teacher()->where('act', 1)->where('banned', 0);
        }, 'timePackage' => function ($q) {
            $q->orderBy('price', 'asc');
        }]);
    }
    public function getFirstPrice()
    {
        $ret = [];
        $ret['price'] = '';
        $ret['price_old'] = '';
        $ret['sale_percent'] = 0;
        $timePackage = $this->timePackage->first();
        if (isset($timePackage)) {
            $ret['price'] = $timePackage->price;
            $ret['price_old'] = $timePackage->price_old;
            $ret['sale_percent'] = $timePackage->price_old > $timePackage->price ? (int)(($timePackage->price_old - $timePackage->price) * 100 / $timePackage->price_old) : 0;
        }
        return $ret;
    }
    public function isOwn($user = null)
    {
        if ($this->isFree()) return true;
        if (!isset($user)) return false;
        $userCourse = $this->userCourse()->where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
            })
            ->first();
        if (isset($userCourse)) {
            return true;
        }
        $userCourseComboAllCount = $user->userCourseCombo()->whereHas('courseCombo', function ($q) {
            $q->where('all_course', 1);
        })
            ->where(function ($q) {
                $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
            })
            ->first();
        if (isset($userCourseComboAllCount)) {
            return true;
        }
        $idCourse = $this->id;
        $userCourseComboSpecialCourse = $user->userCourseCombo()->whereHas('courseCombo', function ($q) use ($idCourse) {
            $q->where('all_course', '!=', 1)->whereHas('course', function ($q) use ($idCourse) {
                $q->where('id', $idCourse);
            });
        })
            ->where(function ($q) {
                $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
            })
            ->first();
        if (isset($userCourseComboSpecialCourse)) {
            return true;
        }
        return false;
    }
    public function updateTimePackage($dataTimePackage)
    {
        $listTimePackage = \Support::extractJson($dataTimePackage);
        $arrOldItemId = [];
        $listNewItem = [];
        foreach ($listTimePackage as $timePackage) {
            if ($timePackage['id_item'] > 0) {
                array_push($arrOldItemId, $timePackage['id_item']);
                CourseTimePackage::where('id', $timePackage['id_item'])
                    ->update([
                        'name' => $timePackage['name'] ?? '',
                        'description' => $timePackage['description'] ?? '',
                        'number_day' => $timePackage['number_day'] ?? '',
                        'is_forever' => $timePackage['is_forever'] ?? 0,
                        'price' => $timePackage['price'] ?? 0,
                        'price_old' => $timePackage['price_old'] ?? 0
                    ]);
            } else {
                array_push($listNewItem, $timePackage);
            }
        }
        $this->timePackage()->whereNotIn('id', $arrOldItemId)->delete();
        if (count($listNewItem) == 0) return;
        $dataInsert = [];
        foreach ($listNewItem as $item) {
            $dataAdd = [];
            $dataAdd['course_id'] = $this->id;
            $dataAdd['name'] = $item['name'] ?? '';
            $dataAdd['description'] = $item['description'] ?? '';
            $dataAdd['number_day'] = $item['number_day'] ?? '';
            $dataAdd['is_forever'] = $item['is_forever'] ?? 0;
            $dataAdd['price'] = $item['price'] ?? 0;
            $dataAdd['price_old'] = $item['price_old'] ?? 0;
            $dataAdd['created_at'] = now();
            $dataAdd['updated_at'] = now();
            array_push($dataInsert, $dataAdd);
        }
        CourseTimePackage::insert($dataInsert);
        $listFinalTimePackage = $this->timePackage()->get();
        $timePackages = [];
        foreach ($listFinalTimePackage as $key => $itemTimePackage) {
            $timePackages[$key] = [];
            $timePackages[$key]['id_item'] = $itemTimePackage->id;
            $timePackages[$key]['name'] = $itemTimePackage->name;
            $timePackages[$key]['description'] = $itemTimePackage->description;
            $timePackages[$key]['number_day'] = $itemTimePackage->number_day;
            $timePackages[$key]['is_forever'] = $itemTimePackage->is_forever;
            $timePackages[$key]['price'] = $itemTimePackage->price;
            $timePackages[$key]['price_old'] = $itemTimePackage->price_old;
        }
        $this->time_package = json_encode($timePackages);
        $this->save();
    }

    public function percentStudy()
    {
        $videos = $this->videos;
        $totalTime = 0;
        $totalStuding = 0;
        foreach ($videos as $video) {
            $videoDone = $video->users->first(function ($q) use ($video) {
                return $q->pivot->user_id == \Auth::id() && $q->pivot->course_video_id == $video->id;
            });
            if ($videoDone != null) {
                $totalStuding += $video->duration;
            }
            $totalTime += $video->duration;
        }
        return round($totalStuding / $totalTime * 100);
    }
}
