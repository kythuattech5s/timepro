<?php
namespace CourseManage\Controllers;

use vanhenry\manager\controller\BaseAdminController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;

class OrderCourseManageController extends BaseAdminController
{
    public function viewOrder (Request $request)
    {
        $order = Order::with('user','paymentMethod','orderStatus','orderDetail')->find($request->id);
        if (!isset($order)) {
            if (isset($request->returnurl)) {
                return redirect(base64_decode($request->returnurl));
            } else{
                abort(404);
            }
        }
        $returnUrl = isset($request->returnurl) ? base64_decode($request->returnurl):$this->admincp;
        return view('vh::view_orders.view_order',compact('order','returnUrl'));
    }
    public function changeOrderStatus (Request $request)
    {
        $order = Order::find($request->order);
        if (!isset($order)) {
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
        if (!$order->changeStatusAble()) {
            return response()->json([
                'code' => 100,
                'message' => 'Không thể thay đổi trạng thái đơn hàng'
            ]);
        }
        $order->order_status_id = $orderStatus->id;
        if ($order->order_status_id == OrderStatus::CANCEL) {
            $order->cancel_user_type = 'admin';
            $order->user_cancel_id = \Auth::guard('h_users')->id();
        }
        if ($order->order_status_id == OrderStatus::PAID) {
            $order->admin_confirm_id = \Auth::guard('h_users')->id();
        }
        $order->save();
        if ($order->order_status_id == OrderStatus::PAID) {
            \Event::dispatch('course.manager.order.success', array($order->id));
        }
        elseif ($order->order_status_id == OrderStatus::CANCEL) {
            \Event::dispatch('course.manager.order.cancel', array($order->id));
        }
        return response()->json([
            'code' => 200,
            'message' => 'Thay đổi trạng thái đơn hàng thành công'
        ]);
    }
}