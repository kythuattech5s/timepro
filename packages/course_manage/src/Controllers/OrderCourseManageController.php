<?php
namespace CourseManage\Controllers;

use vanhenry\manager\controller\BaseAdminController;
use Illuminate\Http\Request;
use App\Models\OrderCourse;
use App\Models\OrderCourseCombo;
use App\Models\OrderStatus;

class OrderCourseManageController extends BaseAdminController
{
    public function viewOrderCourse (Request $request)
    {
        $orderCourse = OrderCourse::with('user','paymentMethod','orderStatus','orderCourseDetail')->find($request->id);
        if (!isset($orderCourse)) {
            if (isset($request->returnurl)) {
                return redirect(base64_decode($request->returnurl));
            } else{
                abort(404);
            }
        }
        $returnUrl = isset($request->returnurl) ? base64_decode($request->returnurl):$this->admincp;
        return view('vh::view_orders.view_order_course',compact('orderCourse','returnUrl'));
    }
    public function viewOrderCourseCombo (Request $request)
    {
        $orderCourseCombo = OrderCourseCombo::with('user','paymentMethod','orderStatus','orderCourseComboDetail')->find($request->id);
        if (!isset($orderCourseCombo)) {
            if (isset($request->returnurl)) {
                return redirect(base64_decode($request->returnurl));
            } else{
                abort(404);
            }
        }
        $returnUrl = isset($request->returnurl) ? base64_decode($request->returnurl):$this->admincp;
        return view('vh::view_orders.view_order_course_combo',compact('orderCourseCombo','returnUrl'));
    }
    public function changeOrderCourseStatus  (Request $request)
    {
        $orderCourse = OrderCourse::find($request->order_course);
        if (!isset($orderCourse)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin đơn hàng khóa học'
            ]);
        }
        $orderStatus = OrderStatus::find($request->status);
        if (!isset($orderStatus)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy trạng thái'
            ]);
        }
        if (!$orderCourse->changeStatusAble()) {
            return response()->json([
                'code' => 100,
                'message' => 'Không thể thay đổi trạng thái đơn hàng'
            ]);
        }
        $orderCourse->order_status_id = $orderStatus->id;
        $orderCourse->save();
        if ($orderCourse->order_status_id == OrderStatus::PAID) {
            \Event::dispatch('course.manager.order_course.success', array($orderCourse->id));
        }
        return response()->json([
            'code' => 200,
            'message' => 'Thay đổi trạng thái đơn hàng thành công'
        ]);
    }
    public function changeOrderCourseComboStatus (Request $request)
    {
        $orderCourseCombo = OrderCourseCombo::find($request->order_course_combo);
        if (!isset($orderCourseCombo)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin đơn hàng gói Vip'
            ]);
        }
        $orderStatus = OrderStatus::find($request->status);
        if (!isset($orderStatus)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy trạng thái'
            ]);
        }
        if (!$orderCourseCombo->changeStatusAble()) {
            return response()->json([
                'code' => 100,
                'message' => 'Không thể thay đổi trạng thái đơn hàng'
            ]);
        }
        $orderCourseCombo->order_status_id = $orderStatus->id;
        $orderCourseCombo->save();
        if ($orderCourseCombo->order_status_id == OrderStatus::PAID) {
            \Event::dispatch('course.manager.order_course_combo.success', array($orderCourseCombo->id));
        }
        return response()->json([
            'code' => 200,
            'message' => 'Thay đổi trạng thái đơn hàng thành công'
        ]);
    }
}