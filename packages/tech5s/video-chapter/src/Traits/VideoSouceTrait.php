<?php

namespace Tech5s\VideoChapter\Traits;

use Illuminate\Http\Request;
use Tech5s\VideoChapter\Models\CourseVideo;

trait VideoSouceTrait
{
    public function videos()
    {
        return $this->hasMany(CourseVideo::class);
    }
}
