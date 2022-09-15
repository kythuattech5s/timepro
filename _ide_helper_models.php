<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 */
	class BaseModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Course
 *
 * @property int $id
 * @property string|null $name Tên
 * @property string|null $slug Slug
 * @property string|null $short_content Nội dung ngắn
 * @property string|null $content Nội dung
 * @property string|null $img Ảnh
 * @property string|null $video_trailer Video giới thiệu
 * @property string|null $img_video_trailer Ảnh video trailer
 * @property int|null $teacher_id Giảng viên
 * @property string|null $duration Thời lượng khóa học
 * @property int|null $act Kích hoạt
 * @property int|null $ord Sắp xếp
 * @property string|null $seo_title Tiêu đề seo
 * @property string|null $seo_key Từ khóa seo
 * @property string|null $seo_des Mô tả seo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày sửa
 * @property string|null $time_package Gói thời gian
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseCategory[] $category
 * @property-read int|null $category_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseCourseCategory[] $pivot
 * @property-read int|null $pivot_count
 * @property-read \App\Models\User|null $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereImgVideoTrailer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTimePackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereVideoTrailer($value)
 */
	class Course extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CourseCategory
 *
 * @property int $id
 * @property string|null $name Tên khóa học
 * @property string|null $slug Slug
 * @property string|null $img Hình ảnh
 * @property string|null $short_content Ghi chú
 * @property string|null $content Nội dung
 * @property int|null $act Kích hoạt
 * @property int|null $ord Sắp xếp
 * @property string|null $seo_title Tiêu đề seo
 * @property string|null $seo_key Từ khóa seo
 * @property string|null $seo_des Mô tả seo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày sửa
 * @property int|null $parent Sắp xếp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $course
 * @property-read int|null $course_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCategory whereUpdatedAt($value)
 */
	class CourseCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CourseCombo
 *
 * @property int $id
 * @property string $name Tên
 * @property string $slug Slug
 * @property string|null $img Ảnh
 * @property int|null $price Giá
 * @property int|null $price_old Giá cũ
 * @property string|null $content Mô tả
 * @property int|null $act Kích hoạt
 * @property int|null $ord Sắp xếp
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $course
 * @property-read int|null $course_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseCourseCombo[] $pivot
 * @property-read int|null $pivot_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo wherePriceOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCombo whereUpdatedAt($value)
 */
	class CourseCombo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CourseCourseCategory
 *
 * @property int $course_id ID khóa học
 * @property int $course_category_id ID danh mục khóa học
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \App\Models\CourseCategory $courseCategory
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCategory whereCourseCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCategory whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCategory whereUpdatedAt($value)
 */
	class CourseCourseCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CourseCourseCombo
 *
 * @property int $course_id ID khóa học
 * @property int $course_combo_id ID combo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \App\Models\Course $course
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCombo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCombo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCombo query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCombo whereCourseComboId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCombo whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCombo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseCourseCombo whereUpdatedAt($value)
 */
	class CourseCourseCombo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $code
 * @property int|null $province_id
 * @property string|null $lat Vĩ độ
 * @property string|null $long Kinh độ
 * @property int|null $crawled Đã lấy tọa độ
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCrawled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereProvinceId($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Email
 *
 * @property int $id
 * @property string|null $username Email
 * @property string|null $password Password
 * @property int|null $count_usage Số lần đã sử dụng
 * @property int|null $act Kích hoạt
 * @property int|null $ord Sắp xếp
 * @property string $mail_driver Mail Driver
 * @property string $mail_host Mail Host
 * @property string $mail_port Mail Port
 * @property string $mail_address Địa chỉ address
 * @property string $mail_from_address Địa chỉ email gửi
 * @property string $mail_encryption Kiểu kết nối
 * @property string $mail_from_name Tên mail gửi
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Email query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereCountUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMailDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMailEncryption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMailFromAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMailFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMailHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereMailPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Email whereUsername($value)
 */
	class Email extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Exam
 *
 * @property int $id
 * @property string|null $name Tên
 * @property string|null $slug Slug
 * @property string|null $img Hình ảnh
 * @property string|null $short_content Nội dung ngắn
 * @property int|null $time Thời gia làm bài (phút)
 * @property int|null $act Kích hoạt
 * @property int|null $ord Sắp xếp
 * @property string|null $seo_title Tiêu đề seo
 * @property string|null $seo_key Từ khóa seo
 * @property string|null $seo_des Mô tả seo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamCategory[] $category
 * @property-read int|null $category_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamResult[] $examResult
 * @property-read int|null $exam_result_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamExamCategory[] $pivot
 * @property-read int|null $pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamQuestion[] $pivotQuestion
 * @property-read int|null $pivot_question_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereUpdatedAt($value)
 */
	class Exam extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamCategory
 *
 * @property int $id
 * @property string|null $name Tên
 * @property string|null $slug Slug
 * @property string|null $img Hình ảnh
 * @property int|null $parent Danh mục cha
 * @property string|null $short_content Nội đung ngắn
 * @property string|null $content Nội dung
 * @property int|null $act Kích hoạt
 * @property int|null $ord Sắp xếp
 * @property string|null $seo_title Tiêu đề seo
 * @property string|null $seo_key Từ khóa seo
 * @property string|null $seo_des Mô tả seo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exam[] $exam
 * @property-read int|null $exam_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamCategory whereUpdatedAt($value)
 */
	class ExamCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamExamCategory
 *
 * @property int $exam_id Id đề kiểm tra
 * @property int $exam_category_id Id danh mục đề kiểm tra
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \App\Models\ExamCategory $examCategory
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamExamCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamExamCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamExamCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamExamCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamExamCategory whereExamCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamExamCategory whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamExamCategory whereUpdatedAt($value)
 */
	class ExamExamCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamQuestion
 *
 * @property int $exam_id Id đề bài
 * @property int $question_id Id câu hỏi
 * @property int|null $point Điểm
 * @property int|null $ord Sắp xếp
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \multiplechoicequestions\managequestion\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamQuestion whereUpdatedAt($value)
 */
	class ExamQuestion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamResult
 *
 * @property int $id
 * @property int|null $user_id User Id
 * @property int|null $exam_id Bài kiểm tra Id
 * @property int|null $point_achieved Số điểm đạt được
 * @property int|null $total_point Tổng số điểm
 * @property int|null $total_question_done Tổng số câu hoàn thành
 * @property int|null $total_question Tổng số câu hỏi
 * @property string|null $exam_info Thông tin bài kiểm tra
 * @property string|null $question_info Thông tin câu trả lời
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property int|null $total_time Thời gian làm bài luyện tập
 * @property string|null $percen_done Phần trăm hoàn thành
 * @property-read \App\Models\Exam|null $exam
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereExamInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult wherePercenDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult wherePointAchieved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereQuestionInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereTotalPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereTotalQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereTotalQuestionDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereTotalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamResult whereUserId($value)
 */
	class ExamResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Gender
 *
 * @property int $id
 * @property string|null $name Giới tính
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Gender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Gender query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Gender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gender whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gender whereUpdatedAt($value)
 */
	class Gender extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $keyword
 * @property string|null $vi_value
 * @property string|null $en_value
 * @property string|null $ko_value
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $act
 * @property int|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereEnValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereKoValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereViValue($value)
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string|null $link Link
 * @property string|null $name Tên
 * @property string|null $icon Icon
 * @property int|null $ord Sắp xếp
 * @property int|null $act Kích hoạt
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày sửa
 * @property int|null $menu_category_id Danh mục menu
 * @property int|null $parent Cha
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuCategory[] $menuCategories
 * @property-read int|null $menu_categories_count
 * @property-read \App\Models\MenuCategory|null $menuCategory
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MenuCategory
 *
 * @property int $id
 * @property string|null $name Tên
 * @property int|null $ord Sắp xếp
 * @property int|null $act Kích hoạt
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu[] $menus
 * @property-read int|null $menus_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuCategory whereUpdatedAt($value)
 */
	class MenuCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\News
 *
 * @property int $id
 * @property string|null $name Tên tin tức
 * @property string|null $slug Đường dẫn
 * @property string|null $img Ảnh
 * @property string|null $short_content Nội dung ngắn
 * @property string|null $content Nội dung bài viết
 * @property string|null $publish_by Đăng bởi
 * @property int|null $act Kích hoạt
 * @property int|null $home Hiển thị trang chủ
 * @property int|null $hot Bài viết nổi bật
 * @property int|null $count Số lượt xem
 * @property int|null $ord Sắp xếp
 * @property string|null $seo_title Tiêu đề seo
 * @property string|null $seo_key Từ khóa seo
 * @property string|null $seo_des Mô tả seo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NewsCategory[] $category
 * @property-read int|null $category_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NewsNewsCategory[] $pivot
 * @property-read int|null $pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NewsTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News wherePublishBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewsCategory
 *
 * @property int $id
 * @property string|null $name Tên danh mục tin tức
 * @property string|null $slug Đường dẫn
 * @property string|null $img Banner
 * @property string|null $short_content Nội dung ngắn
 * @property string|null $content Nội dung
 * @property int|null $act Kích hoạt
 * @property int|null $home Hiển thị trang chủ
 * @property int|null $ord Sắp xếp
 * @property string|null $seo_title Tiêu đề seo
 * @property string|null $seo_key Từ khóa seo
 * @property string|null $seo_des Mô tả seo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property int|null $parent Danh mục cha
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\News[] $news
 * @property-read int|null $news_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsCategory whereUpdatedAt($value)
 */
	class NewsCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewsNewsCategory
 *
 * @property int $news_id Id tin tức
 * @property int $news_category_id Id danh mục tin tức
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \App\Models\NewsCategory|null $newsCategory
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsCategory whereNewsCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsCategory whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsCategory whereUpdatedAt($value)
 */
	class NewsNewsCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewsNewsTag
 *
 * @property int $news_id Id tin tức
 * @property int $news_tag_id Id tag tin tức
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsTag whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsTag whereNewsTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsNewsTag whereUpdatedAt($value)
 */
	class NewsNewsTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NewsTag
 *
 * @property int $id
 * @property string|null $name Tên tag
 * @property string|null $slug Đường dẫn
 * @property string|null $img Ảnh
 * @property string|null $short_content Nội dung ngắn
 * @property string|null $content Nội dung
 * @property int|null $act Kích hoạt
 * @property int|null $ord Sắp xếp
 * @property string|null $seo_title Tiêu đề seo
 * @property string|null $seo_key Từ khóa seo
 * @property string|null $seo_des Mô tả seo
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\News[] $news
 * @property-read int|null $news_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsTag whereUpdatedAt($value)
 */
	class NewsTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderCourse
 *
 * @property int $id
 * @property string|null $code Mã đơn hàng
 * @property int|null $user_id User
 * @property string|null $name Tên người đặt hàng
 * @property string|null $phone Số điện thoại
 * @property string|null $email Email
 * @property string|null $address Địa chỉ
 * @property string|null $content Ghi chú
 * @property int|null $order_status_id Trạng thái thanh toán
 * @property int|null $payment_method_id Phương thức thanh toán
 * @property int|null $total Tạm tính
 * @property int|null $total_final Tổng tiền
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày sửa
 * @property-read \App\Models\OrderStatus|null $orderStatus
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereTotalFinal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCourse whereUserId($value)
 */
	class OrderCourse extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 */
	class OrderStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property string|null $name Phương thức
 * @property string|null $img Hình ảnh
 * @property string|null $content Nội dung
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property int|null $act
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Province
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property string|null $lat Vĩ độ
 * @property string|null $long Kinh độ
 * @property int|null $crawled
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCrawled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 */
	class Province extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\QueueEmail
 *
 * @property int $id ID
 * @property string|null $title Tiêu đề email
 * @property string|null $content Nội dung
 * @property string|null $from Gửi từ
 * @property string|null $to_name
 * @property string|null $to Gửi tới
 * @property \Illuminate\Support\Carbon|null $created_at Thời gian tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Thời gian cập nhật
 * @property int|null $status Trạng thái
 * @property int|null $count_error Sồ lần gửi thất bại
 * @property string|null $attach_file Danh sách file đính kèm
 * @property string|null $result Kết quả gửi
 * @property int|null $is_sms Là SMS
 * @property string|null $bcc BCC
 * @property string|null $cc CC
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereAttachFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereBcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereCountError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereIsSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereToName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueEmail whereUpdatedAt($value)
 */
	class QueueEmail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Teacher
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 */
	class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name Họ và tên
 * @property string|null $email Email
 * @property string|null $phone Số điện thoại
 * @property string|null $password Mật khẩu
 * @property string|null $img Ảnh đại diện
 * @property string|null $address Địa chỉ
 * @property string|null $birthday Ngày sinh
 * @property int|null $gender_id Giới tính
 * @property int|null $act Kích hoạt
 * @property int|null $banned Đã bị banned
 * @property string|null $token Xác nhận mã OTP
 * @property string|null $remember_token Ghi nhớ đăng nhập
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @property string|null $last_login_time Ngày tạo
 * @property int|null $user_type_id Kích hoạt
 * @property-read \App\Models\District|null $district
 * @property-read \App\Models\Gender|null $gender
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Province|null $province
 * @property-read \App\Models\UserType|null $userType
 * @property-read \App\Models\Ward|null $ward
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserTypeId($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserType
 *
 * @property int $id
 * @property string|null $name Họ và tên
 * @property \Illuminate\Support\Carbon|null $created_at Ngày tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Ngày cập nhật
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|UserType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|UserType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserType whereUpdatedAt($value)
 */
	class UserType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VLanguage
 *
 * @property string $keyword
 * @property string|null $vi_value
 * @property string|null $en_value
 * @property string|null $note
 * @property string|null $create_at
 * @property string|null $update_at
 * @property int|null $act
 * @property int|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereCreateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereEnValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereUpdateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VLanguage whereViValue($value)
 */
	class VLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VRoutes
 *
 * @property int $id
 * @property string|null $vi_name Tên tiếng việt
 * @property string|null $en_name Tên tiếng anh
 * @property string|null $controller Controller
 * @property string|null $table Bảng
 * @property int|null $map_id Map id
 * @property int|null $is_static Là link tĩnh
 * @property int|null $in_sitemap Được hiển thị trong sitemap
 * @property string|null $code Mã link tĩnh(để lấy link theo ngôn ngữ)
 * @property string|null $vi_link Link tiếng việt
 * @property string|null $en_link Link tiếng anh
 * @property string|null $vi_seo_title Tiêu đề seo tiếng việt
 * @property string|null $vi_seo_key Từ khóa seo tiếng việt
 * @property string|null $vi_seo_des Mô tả seo tiếng việt
 * @property string|null $en_seo_title Tiêu đề seo tiếng anh
 * @property string|null $en_seo_key Từ khóa seo tiếng anh
 * @property string|null $en_seo_des Mô tả seo tiếng anh
 * @property \Illuminate\Support\Carbon|null $created_at Thời gian tạo
 * @property \Illuminate\Support\Carbon|null $updated_at Thời gian cập nhật
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereController($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereEnLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereEnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereEnSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereEnSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereEnSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereInSitemap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereIsStatic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereMapId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereViLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereViName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereViSeoDes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereViSeoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VRoutes whereViSeoTitle($value)
 */
	class VRoutes extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ward
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $district_id
 * @property string|null $name
 * @property string|null $lat Vĩ độ
 * @property string|null $long Kinh độ
 * @property int|null $crawled Đã lấy tọa độ
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel act()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearch($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel fullTextSearchNoRelevance($columns, $term)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel ord()
 * @method static \Illuminate\Database\Eloquent\Builder|Ward query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel slug($slug, $table = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereCrawled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereName($value)
 */
	class Ward extends \Eloquent {}
}

