<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseCombo;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\OrderStatus;
use App\Models\UserType;
use Auth;
use Illuminate\Http\Request;
use Support;
use Tech5sCart;

class ManageUserCourseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) {
            if (request()->ajax()) {
                echo json_encode([
                    'code' => 100,
                    'message' => 'Vui lòng đăng nhập',
                    'redirect_url' => \VRoute::get("login")
                ]);
                die();
            }else{
                redirect()->to(\VRoute::get("login"))->with('messageNotify', 'Vui lòng đăng nhập')->with('typeNotify', 100)->send();
                throw new \Exception("Tài khoản của bạn không có chức năng này", 100);
            }
        }
        $user = Auth::user();
        if ($user->user_type_id != UserType::NORMAL_ACCOUNT) {
            if (request()->ajax()) {
                echo json_encode([
                    'code' => 100,
                    'message' => 'Tài khoản của bạn không có chức năng này',
                    'redirect_url' => \VRoute::get("login")
                ]);
                die();
            } else {
                redirect()->to(\VRoute::get("home"))->with('messageNotify', 'Tài khoản của bạn không có chức năng này')->with('typeNotify', 100)->send();
                throw new \Exception("Tài khoản của bạn không có chức năng này", 100);
            }
        }
    }
    
    public function myCourse(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listUserCourseId = $user->userAllCourseId();
        $strIdCourseUser = trim(implode(',', $listUserCourseId->toArray()).',-1',',');
        $type = $request->type ?? 1;
        $activeCategoryId = $request->category ?? null;
        $sort = $request->sort ?? 1;
        $sortStr = 'id desc';
        if ($sort == 2) {
            $sortStr = 'id asc';
        }
        $listItems = Course::baseView()->whereIn('id', $listUserCourseId)
                                        ->when($activeCategoryId,function($q) use ($activeCategoryId){
                                            $q->whereHas('category',function($q) use ($activeCategoryId){
                                                $q->where('id',$activeCategoryId);
                                            });
                                        })
                                        ->when($type != 1,function($q) use($type,$user,$strIdCourseUser) {
                                            $havingString = '';
                                            switch ($type) {
                                                case 2:
                                                    $havingString = 'HAVING percent_done = 0';
                                                    break;
                                                case 3:
                                                    $havingString = 'HAVING percent_done > 0 and percent_done < 100';
                                                    break;
                                                case 4:
                                                    $havingString = 'HAVING percent_done = 100';
                                                    break;
                                                default:
                                                    break;
                                            }
                                            $q->whereRaw(vsprintf("id in (select id from (select id,case when count_video = 0 then 0 else (100*count_video_done/count_video) end as percent_done from (SELECT *,(SELECT count(*) from course_videos WHERE course_videos.course_id = courses.id) as count_video,(SELECT count(*) from course_video_user WHERE course_video_user.course_id = courses.id and course_video_user.user_id = %s) as count_video_done from courses where id in (%s)) as course_videos_statical %s) as base)",[$user->id,$strIdCourseUser,$havingString]));
                                        })
                                        ->orderByRaw($sortStr)
                                        ->paginate(6);
        $listCourseCategory = CourseCategory::act()->get();
        return view('auth.account.my_course', compact('user', 'listItems','listCourseCategory', 'currentItem','type','activeCategoryId','sort'));
    }
    public function myExam(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $mainCourseId = str_replace('lam-bai-kiem-tra-','',\FCHelper::getSegment($request, 2));
        $mainCourse = Course::act()->whereHas('exam')->with('exam')->find($mainCourseId);
        if ($mainCourseId != '') {
            if (!isset($mainCourse) || !$mainCourse->isOwn($user)) {
                return Support::redirectTo(\VRoute::get("my_exam"),100,'Không tìm thấy thông tin kỳ thi');
            }
            $examResult = $mainCourse->examResult()->where('user_id',$user->id)->first();
            if (isset($examResult)) {
                return Support::redirectTo(\VRoute::get("my_exam_result").'/ket-qua-bai-thi-'.$examResult->id,200,'Bạn đã hoàn thành bài kiểm tra này rồi');
            }
            $exam = $mainCourse->exam;
            $currentItem->vi_name = $currentItem->vi_name.' - '.$exam->name;
            $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - '.$exam->name;
            $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - '.$exam->name;
            $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - '.$exam->name;
            return view('auth.account.exams.do_exam', compact('user','currentItem','mainCourse','exam'));
        }
        $listUserCourseId = $user->userAllCourseId();
        $strIdCourseUser = trim(implode(',', $listUserCourseId->toArray()).',-1',',');
        $listItems = Course::baseView()->whereIn('id', $listUserCourseId)
                                        ->whereRaw(vsprintf("id in (select id from (select id,case when count_video = 0 then 0 else (100*count_video_done/count_video) end as percent_done from (SELECT *,(SELECT count(*) from course_videos WHERE course_videos.course_id = courses.id) as count_video,(SELECT count(*) from course_video_user WHERE course_video_user.course_id = courses.id and course_video_user.user_id = %s) as count_video_done from courses where id in (%s)) as course_videos_statical having percent_done = 100) as base)",[$user->id,$strIdCourseUser]))
                                        ->whereHas('exam')
                                        ->whereDoesntHave('examResult',function($q) use ($user){
                                            $q->where('user_id',$user->id);
                                        })
                                        ->paginate(6);
        return view('auth.account.exams.my_exam', compact('user','currentItem','listItems'));
    }
    public function sendExamResult(Request $request)
    {
        $user = Auth::user();
        $data = $request->data ?? [];
        $dataExam = $data['exam'] ?? [];
        unset($data['exam']);
        $examId = $dataExam['idx'] ?? 0;
        $mainCourse = Course::act()->whereHas('exam')->with('exam')->find(str_replace('lam-bai-kiem-tra-','',$dataExam['map_id'] ?? 0));
        if (!isset($mainCourse) || $mainCourse->exam_id != $examId) {
            return response()->json([
                'code'=>100,
                'message'=>'Thiếu thông tin dữ liệu. Không thế xác nhận kết quả bài thi.'
            ]);
        }
        $examResult = $mainCourse->examResult()->where('user_id',$user->id)->first();
        if (isset($examResult)) {
            return response()->json([
                'code'=>200,
                'message'=>'Bạn đã hoàn thành bài kiểm tra này rồi'
            ]);
        }

        $listQuestionPivot = $mainCourse->exam->pivotQuestion()->whereHas('question')->with('question')->get();
        $pointAchieved = 0;
        $totalPoint = 0;
        $totalQuestion = count($listQuestionPivot);
        $totalQuestionDone = 0;
        foreach ($listQuestionPivot as $itemQuestionPivot) {
            $question = $itemQuestionPivot->question;
            $totalPoint += $itemQuestionPivot->point;
            if (isset($data[$question->id]['answer']) && $question->check($data[$question->id]['answer'])) {
                $pointAchieved += $itemQuestionPivot->point;
                $totalQuestionDone++;
            }
            $data[$question->id]['answer'] = $data[$question->id]['answer'] ?? '';
        }
        $percenDone = $totalQuestion > 0 ? 100*$totalQuestionDone/$totalQuestion:0;
        $startTime = \Carbon\Carbon::createFromFormat(Exam::FORMAT_START_TIME,$dataExam['start_time']);
        $examResult = new ExamResult;
        $examResult->total_time = now()->timestamp - $startTime->timestamp;
        $examResult->user_id = $user->id;
        $examResult->exam_id = $examId;
        $examResult->percen_done = $percenDone;
        $examResult->course_id = $mainCourse->id;
        $examResult->point_achieved = $pointAchieved;
        $examResult->total_point = $totalPoint;
        $examResult->total_question_done = $totalQuestionDone;
        $examResult->total_question = $totalQuestion;
        $examResult->exam_info = json_encode($dataExam);
        $examResult->question_info = json_encode($data);
        $examResult->save();
        return response()->json([
            'code' => 200,
            'message' => 'Bài thi đã hoàn thành',
            'link_back' => \VRoute::get("my_exam"),
            'html' => view('auth.account.exams.exam_result_ajax', compact('user','examResult','mainCourse'))->render(),
            'link_result' => \VRoute::get("my_exam_result").'/ket-qua-bai-thi-'.$examResult->id
        ]);
    }
    public function myExamResult (Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $examResultId = str_replace('ket-qua-bai-thi-','',\FCHelper::getSegment($request, 2));
        $examResult = ExamResult::whereHas('exam')->with('exam')->find($examResultId);
        if ($examResultId != '') {
            if (!isset($examResult)) {
                return Support::redirectTo(\VRoute::get("my_exam_result"),100,'Không tìm thấy thông tin kết quả bài thi');
            }
            $exam = $examResult->exam;
            $currentItem->vi_name = $currentItem->vi_name.' - '.$exam->name;
            $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - '.$exam->name;
            $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - '.$exam->name;
            $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - '.$exam->name;
            return view('auth.account.exams.my_exam_result_detail', compact('user','currentItem','examResult','exam'));
        }
        $listItems = $user->examResult()->whereHas('exam')->with('course','exam')->paginate(6);
        return view('auth.account.exams.my_exam_result', compact('user','currentItem','listItems'));
    }
    public function upgradeVip(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listCourseCombo = CourseCombo::act()->get();
        return view('auth.account.upgrade_vip', compact('user', 'listCourseCombo', 'currentItem'));
    }

    public function myOrder (Request $request,$route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $action = \FCHelper::getSegment($request, 2);
        $activeOrderStatus = OrderStatus::where('action',$action)->first();
        $activeStatus = isset($activeOrderStatus) ? $activeOrderStatus->id:OrderStatus::WAIT_PAYMENT;
        $listOrderStatus = OrderStatus::get();
        $listItems = $user->orders()->orderBy('id','desc')->with('orderDetail','paymentMethod','orderStatus')->where('order_status_id',$activeStatus)->paginate(6);
		return view('auth.account.my_order',compact('user','currentItem','listOrderStatus','activeStatus','listItems'));
    }

    public function restoreOrder(Request $request)
    {
        $user = Auth::user();
        $order = $user->orders()->with('orderDetail')->find($request->order);
        if (!isset($order)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin đơn hàng'
            ]);
        }
        foreach ($order->orderDetail as $itemOrderDetail) {
            $dataTimePackage = [];
            $dataTimePackage['id'] = $itemOrderDetail->time_package_id;
            $dataTimePackage['name'] = $itemOrderDetail->name_time_package;
            $dataTimePackage['price'] = $itemOrderDetail->price;
            $dataTimePackage['price_old'] = $itemOrderDetail->price_old;
            $dataTimePackage['description'] = $itemOrderDetail->description;
            $dataTimePackage['number_day'] = $itemOrderDetail->number_day;
            $dataTimePackage['is_forever'] = $itemOrderDetail->is_forever;
            Tech5sCart::instance($itemOrderDetail->type);
            Tech5sCart::add($itemOrderDetail->map_id,$itemOrderDetail->name,1,$itemOrderDetail->price,0,$dataTimePackage);
        }
        session()->flash('typeNotify',200);
        session()->flash('messageNotify','Đã thêm tất cả sản phẩm vào giỏ hàng');
        return response()->json([
            'code' => 200,
            'redirect_url' => \VRoute::get("viewCart")
        ]);
    }

    public function cancelOrder (Request $request)
    {
        $user = Auth::user();
        $order = $user->orders()->with('orderDetail')->find($request->order);
        if (!isset($order)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin đơn hàng'
            ]);
        }
        $order->order_status_id = OrderStatus::CANCEL;
        $order->cancel_user_type = 'user';
        $order->user_cancel_id = $user->id;
        $order->save();
        session()->flash('typeNotify',200);
        session()->flash('messageNotify','Thay đổi trạng thái đơn hàng thành công.');
        return response()->json([
            'code' => 200,
        ]);
    }
}