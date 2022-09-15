<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tech5s\VideoChapter\Traits\VideoSouceTrait;

class Course extends BaseModel
{
    use HasFactory, VideoSouceTrait;
    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id','id');
    }
    public function pivot(){
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
    public function updateTimePackage($dataTimePackage)
    {
        $listTimePackage = \Support::extractJson($dataTimePackage);
        $arrOldItemId = [];
        $listNewItem = [];
        foreach ($listTimePackage as $timePackage) {
            if ($timePackage['id_item'] > 0) {
                array_push($arrOldItemId,$timePackage['id_item']);
                CourseTimePackage::where('id',$timePackage['id_item'])
                                ->update([
                                    'name' => $timePackage['name'] ?? '',
                                    'description' => $timePackage['description'] ?? '',
                                    'number_day' => $timePackage['number_day'] ?? '',
                                    'is_forever' => $timePackage['is_forever'] ?? 0,
                                    'price' => $timePackage['price'] ?? 0,
                                    'price_old' => $timePackage['price_old'] ?? 0
                                ]);
            }else{
                array_push($listNewItem,$timePackage);
            }
        }
        $this->timePackage()->whereNotIn('id',$arrOldItemId)->delete();
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
            array_push($dataInsert,$dataAdd);
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
}

