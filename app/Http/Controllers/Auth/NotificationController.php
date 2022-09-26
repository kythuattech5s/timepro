<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Tech5s\Notify\Models\Notification;
use Tech5s\Notify\Models\NotificationCatalog;

class NotificationController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            return redirect()->to('/')->with('typeNotify', 100)->with('messageNotify', 'Vui lòng đăng nhập để thực hiện chức năng này')->send();
        }
    }

    public function index(Request $request)
    {
        $notification_catalogs = NotificationCatalog::where('act', 1)->get();
        $notifications = Auth::user()->notifications();
        $notifications->when(request('catalog'), function ($q, $catalog) {
            $q->where('notification_catalog_id', $catalog);
        });
        $notifications->whereHas('catalog', function ($q) {
            $q->where('act', 1);
        });
        $notifications = $notifications->paginate(10);
        return view('auth.account.notification', compact('notification_catalogs', 'notifications'));
    }

    public function readNotification(Request $request)
    {
        try {
            Notification::find($request->input('id'))->markAsRead();
            return response([
                'code' => 200,
                'message' => 'Đánh dấu đã đọc thành công',
            ]);
        } catch (\Exception $err) {
            return response([
                'code' => 100,
                'message' => "Có lỗi xảy ra $err",
            ]);
        }
    }

    public function deleteNotification(Request $request)
    {
        try {
            Notification::where('notifiable_id', \Auth::id())->where('id', $request->input('id'))->delete();
            return response([
                'code' => 200,
                'message' => 'Xóa thông báo thành công',
            ]);
        } catch (\Exception $err) {
            return response([
                'code' => 100,
                'message' => "Có lỗi xảy ra $err",
            ]);
        }
    }

    public function loadMore(Request $request)
    {
        $notifications = Notification::query();
        if ($request->input('catalog') !== 'all') {
            $notifications->where('notification_catalog_id', $request->input('catalog'));
        }

        $notifications = $notifications->paginate(10);
        return response([
            'code' => 200,
            'html' => view('auth.account.components.list_notifications', compact('notifications'))->render(),
            'isLastPage' => $notifications->onLastPage(),
            'nextPage' => $request->input('page') + 1
        ]);
    }
}
