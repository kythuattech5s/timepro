<?php
namespace CourseManage\Listeners;

use App\Models\Course;
use App\Models\CourseCombo;
use App\Models\Order;

class ManagerEventListener
{
    public function subscribe($events)
    {
        $events->listen('vanhenry.manager.insert.success', function ($table, $data, $id)
        {
            $tbl = $table;
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                $tbl = $table->table_map;
            }
            if ($tbl == 'courses' && isset($data['time_package'])) {
                $course = Course::find($id);
                if (isset($course)) {
                    $course->updateTimePackage($data['time_package']);
                }
            }
            if ($tbl == 'course_combos' && isset($data['time_package'])) {
                $course = CourseCombo::find($id);
                if (isset($course)) {
                    $course->updateTimePackage($data['time_package']);
                }
            }
        });
        $events->listen('vanhenry.manager.update_normal.success', function ($table, $data, $id, $oldData = null)
        {
            $tbl = $table;
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                $tbl = $table->table_map;
            }
            if ($tbl == 'courses' && isset($data['time_package'])) {
                $course = Course::find($id);
                if (isset($course)) {
                    $course->updateTimePackage($data['time_package']);
                }
            }
            if ($tbl == 'course_combos' && isset($data['time_package'])) {
                $course = CourseCombo::find($id);
                if (isset($course)) {
                    $course->updateTimePackage($data['time_package']);
                }
            }
        });
        $events->listen('course.manager.order.success', function ($id)
        {
            $order = Order::find($id);
            if (isset($order)) {
                $order->orderSuccess();
            }
        });
        $events->listen('course.manager.order.cancel', function ($id)
        {
            $order = Order::find($id);
            if (isset($order)) {
                $order->orderCancel();
            }
        });
    }
}
