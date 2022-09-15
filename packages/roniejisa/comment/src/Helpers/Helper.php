<?php

namespace Roniejisa\Comment\Helpers;

use Roniejisa\Comment\Models\News;
use Roniejisa\Comment\Models\Order;
use Roniejisa\Comment\Models\OrderStatusHistory;
use Roniejisa\Comment\Models\Product;
use Auth;
use Roniejisa\Comment\Models\Comment;
use Roniejisa\Comment\Models\LikeComment;
use Roniejisa\Comment\Models\Rating;
use Roniejisa\Helpers\RSMedia;
use stdClass;
use Support;

class Helper
{
    const STATUS_SUCCESS = 5;
    const STATUS_RATING = 6;

    // ADDCOMMENT
    public static function addComment($request, $checkShop = false)
    {
        \DB::beginTransaction();
        // try {
        if (config('cmrsc_comment.checkUser', false)) {
            $user = Auth::user();
        }
        $comment = new Comment;
        if ($user !== null) {
            $comment->user_id = Auth::id();
        }
        if ($checkShop) {
            $checkProductOfShop = self::checkShop($request->map_id);
            if (!$checkProductOfShop) {
                return [
                    'code' => 100,
                    'message' => 'Bạn chỉ có thể đánh giá sau khi đã mua hàng!',
                ];
            }
        }

        if (config('cmrsc_comment.checkOrderDone') && !$checkShop) {
            $checkOrderDone = self::checkOrderDone($request->map_id);
            if (!$checkOrderDone) {
                return [
                    'code' => 100,
                    'message' => 'Bạn chỉ có thể đánh giá sau khi đã mua hàng!',
                ];
            }
        }

        $comment->content = self::noRunScript($request->content);
        if (config('cmrsc_comment.fields.hasOrderId')) {
            $comment->order_type = $request->input('order_type');
            $comment->order_id = $request->input('order_id');
        }

        $comment->map_table = $request->input('map_table');
        $comment->map_id = $request->input('map_id');
        $comment->comment_id = $request->input('comment_id');
        $comment->act = 1;
        if (config('cmrsc_comment.fields.hasImages')) {
            $comment->imgs = $request->hasFile('images') ? json_encode(RSMedia::uploadMultiple('images', config('cmrsc_comment.source')), JSON_UNESCAPED_UNICODE) : null;
        }
        $comment->save();

        if (isset($request->rate)) {
            self::addRating($request, $user, $comment);
        }
        \DB::commit();
        if (isset($request->rate)) {
            // self::buildDataRating($request->input('map_table'), $request->input('map_id'));
        }

        if ($request->input('order_id') !== null) {
            $order = Order::with(['comments' => function ($q) {
                $q->orderBy('created_at', 'DESC');
            }, 'orderProducts' => function ($q) {
                $q->with('product');
            }])->where('user_id', Auth::id())->where('id', $request->input('order_id'))->first();

            return [
                'html' => view('commentRS::order.rating_order', compact('order'))->render(),
                'message' => 'Đánh giá thành công',
                'code' => 200,
            ];
        }

        return $comment;

        // } catch (\Exception$err) {
        //     \DB::rollback();
        //     return [
        //         'code' => 100,
        //         'message' => $err->getMessage(),
        //     ];
        // }
    }

    public static function buildDataRating($table, $id)
    {
        switch ($table) {
            case 'products':
                $product = Product::with('ratings')->find($id);
                $product->info_rating = $product->getRating('add');
                $product->save();
                break;
            case 'news':
                $product = News::with('ratings')->find($id);
                $product->info_rating = $product->getRating('add');
                $product->save();
        }
    }

    public static function getComment($id)
    {
        $comment = Comment::with('childs')->find($id);
        return $comment;
    }

    public static function repCommentShop($request)
    {

        $comment = Comment::find($request->input('comment_id'));

        $newComment = new Comment;
        $newComment->map_table = $comment->map_table;
        $newComment->map_id = $comment->map_id;
        $newComment->content = $request->input('content');
        $newComment->comment_id = $comment->id;
        $newComment->user_id = Auth::id();
        $newComment->act = 1;
        $newComment->save();
        return $newComment;
    }

    public static function checkShop($product_id)
    {
        $product = Product::with('variants')->where('id', $product_id)->where('shop_id', auth::user()->shop->id)->first();
        if ($product) {
            return true;
        }
        return false;
    }

    public static function checkOrderDone($product_id)
    {
        $product = Product::with('variants')->where('id', $product_id)->first();
        $check = Order::where('user_id', \Auth::id())->whereHas('orderProducts', function ($q) use ($product) {
            if ($product->variants->count() > 0) {
                $q->whereIn('order_products.product_id', $product->variants->pluck('id'));
            } else {
                $q->where('order_products.product_id', (int) $product->id);
            }
        })->whereHas('orderStatus', function ($q) {
            //Status bằng 4 đã hoàn thành
            $q->whereIn('order_statuses.id', [Order::STATUS_SUCCESS, Order::STATUS_RATING, Order::STATUS_EXPIRED_REFUND]);
        })->count();
        if ($check == 0) {
            return false;
        }
        return true;
    }

    // ADD RATING
    public static function addRating($request, $user = null, $comment = null)
    {
        $rating = new Rating;
        $rating->map_table = $request->input('map_table');
        $rating->map_id = $request->input('map_id');

        if (config('cmrsc_comment.fields.hasOrderId')) {
            $rating->order_id = $request->input('order_id');
            $rating->order_type = $request->input('order_type');
        }

        if ($user !== null) {
            $rating->user_id = $comment->user_id;
        }
        if ($comment !== null) {
            $rating->comment_id = $comment->id;
        }
        $rating->rating = $request->input('rate');
        $rating->act = 1;
        $rating->save();
        // event('after.user.rating', [$user, $rating]);
        return $rating;
    }

    public static function addCommentAndRatingOrder($request)
    {
        $user = Auth::user();
        $order_id = $request->input('order_id');
        $order = Order::where('user_id', $user->id)->where('id', $order_id)->first();
        if ($order == null) {
            return [
                'code' => 100,
                'message' => 'Đơn hàng không hợp lệ',
            ];
        }

        foreach ($request->map_id as $key => $id) {
            $comment = new Comment;
            $comment->map_table = $request->input('map_table');
            $comment->map_id = $id;
            $comment->content = self::noRunScript($request->content[$key]);
            $comment->user_id = $user->id;
            $comment->order_id = $order_id;
            $comment->comment_id = $request->input('comment_id');
            $comment->act = 1;
            $comment->is_admin = $user->is_admin == 1 ? 1 : 0;
            if (config('cmrsc_comment.fields.hasImages')) {
                $comment->imgs = $request->hasFile('img-' . $key) ? RSMedia::uploadMultiple('img-' . $key, config('cmrsc_comment.source')) : null;
            }
            $comment->save();
            $rating = new Rating;
            $rating->map_table = $request->input('map_table');
            $rating->map_id = $id;

            if ($user !== null) {
                $rating->user_id = $comment->user_id;
                $rating->act = $user->is_admin == 1 ? 1 : 0;
            }
            if ($comment !== null) {
                $rating->comment_id = $comment->id;
            }
            $rating->rating = $request->input('rate-' . $key);
            $rating->act = 1;
            $rating->save();
            // self::buildDataRating($request->input('map_table'), $id);
            // event('after.user.rating', [$user, $rating]);
        }
        $historyOrder = new OrderStatusHistory();
        $historyOrder->before = $order->order_status_id;
        $historyOrder->status = Order::STATUS_RATING;
        $historyOrder->reason = 'Đã đánh giá sản phẩm';
        $historyOrder->who_id = $user->id;
        $historyOrder->order_id = $order->id;
        $historyOrder->who_change = 'users';
        $historyOrder->save();
        $order->order_status_id = Order::STATUS_RATING;
        $order->save();
    }
    // FRESH ITEM
    private static function fetchItem($comment, $type = 'child')
    {
        if ($comment->act == 1) {
            if ($type == 'child') {
                $html = view('commentRS::item_comment', compact('comment'))->render();
                return response([
                    'code' => 200,
                    'message' => 'Bình luận thành công',
                    'html' => $html,
                ]);
            } else {
                $html = view('commentRS::item_comment_child', compact('comment'))->render();
                return response([
                    'code' => 200,
                    'message' => 'Trả lời bình luận thành công',
                    'html' => $html,
                ]);
            }
        } else {
            if ($type == 'child') {
                return response([
                    'code' => 200,
                    'message' => 'Bình luận thành công',
                ]);
            } else {
                return response([
                    'code' => 200,
                    'message' => 'Trả lời bình luận thành công',
                ]);
            }
        }
    }

    // REFRESH COMMENT
    private static function fetchComment($map_table, $map_id)
    {
        $comments = Comment::with(['childs'])->where('map_table', $map_table)->where('map_id', $map_id)->orderBy('created_at', 'DESC')->where('act', 1)->paginate(5);
        $html = view('commentRS::comment', compact('comments'))->render();
        return response([
            'message' => 'Bình luận thành công',
            'code' => 200,
            'html' => $html,
            'lastPage' => $comments->lastPage(),
        ]);
    }

    // FETCH COMMENT ORDER
    private static function fetchCommentOrder($request)
    {
        $order = Order::with(['comments', 'orderProducts' => function ($q) {
            $q->with('product');
        }])->where('user_id', Auth::id())->where('id', $request->order_id)->first();
        $order->time_rating_order = new \DateTime;
        $order->save();
        $html = view('ajax.rating', compact('order'))->render();

        return response([
            'code' => 200,
            'html' => $html,
            'message' => "Bình luận thành công",
        ]);
    }

    // LOADMORE COMMENT CHILD
    public static function fetchCommentChild($request)
    {
        $childs = Comment::with(['childs'])->where('comment_id', $request->comment_id)->where('act', 1)->orderBy('id', 'DESC')->paginate(5);
        $html = view('commentRS::comment_childs', compact('childs'))->render();
        return response([
            'code' => 200,
            'html' => $html,
            'lastPage' => $childs->lastPage(),
        ]);
    }

    public static function fetchCommentMore($request)
    {
        $comments = Comment::with(['childs'])->where('map_table', $request->map_table)->where('map_id', $request->map_id)->where('act', 1)->whereNull('comment_id');
        if (isset($request->filter) || isset($request->sort)) {
            $comments = self::filter($comments);
        } else {
            $comments = $comments->orderBy('id', 'DESC')->paginate(5);
        }

        return self::renderComment($comments);
    }

    // FILLTER RATING
    public static function filterRating($request)
    {
        $comments = Comment::with(['childs', 'user'])->where('map_table', $request->map_table)->where('map_id', $request->map_id)->where('act', 1);
        $comments = self::filter($comments);

        return self::renderComment($comments);
    }

    private static function filter($comments)
    {
        $request = request();
        $filters = is_array($request->filter) ? $request->filter : [$request->filter];
        $star = [];
        foreach ($filters as $filter) {
            if (in_array($filter, [1, 2, 3, 4, 5])) {
                $star[] = $filter;
            }
        }
        if (count($star) > 0) {
            $comments->whereHas('rating', function ($q) use ($star) {
                $q->whereIn('rating', $star);
            });
        }

        if (in_array(6, $filters)) {
            $users = Order::whereHas('orderProducts', function ($q) use ($request) {
                $q->where('product_id', $request->map_id);
            })->whereIn('status', [static::STATUS_SUCCESS, static::STATUS_RATING])->pluck('user_id');
            $comments->whereIn('user_id', $users);
        }

        if (in_array(7, $filters)) {
            $comments->where(function ($q) {
                $q->whereNotNull('imgs')->where('imgs', '<>', '');
            });
        }

        if (in_array(8, $filters) || (isset($request->sort) && $request->sort == 'new')) {
            $comments->orderBy('id', 'DESC');
        }

        if (in_array(9, $filters) || (isset($request->sort) && $request->sort == 'old')) {
            $comments->orderBy('id', 'ASC');
        }
        $comments->whereNull('comment_id');
        return $comments->paginate(5);
    }

    private static function renderComment($comments)
    {
        $html = view('commentRS::comment', compact('comments'))->render();
        return response([
            'code' => 200,
            'html' => $html,
            'lastPage' => $comments->lastPage(),
            'count' => $comments->total(),
        ]);
    }

    public static function likeAndUnlike($request)
    {
        if (!Auth::check() && config('cmrsc_comment.checkUser', false)) {
            return [
                'code' => 100,
                'message' => 'Vui lòng đăng nhập để thực hiện hành động này'
            ];
        }

        $like = LikeComment::where('comment_id', $request->id)->where('user_id', Auth::id())->first();
        if ($like == null) {
            $like == LikeComment::insert([
                'comment_id' => $request->id,
                'user_id' => Auth::id(),
            ]);

            return [
                'code' => 200,
                'message' => 'Thích bình luận thành công',
            ];
        } else {
            LikeComment::where('comment_id', $request->id)->where('user_id', Auth::id())->delete();
            return [
                'code' => 200,
                'message' => 'Đã bỏ thích bình luận',
            ];
        }
    }

    public static function noRunScript($string)
    {
        return htmlentities($string);
    }
    // FIX ERROR SCRIPT TAGS
    public static function strip_all_tags($string, $remove_breaks = false)
    {
        $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
        $string = strip_tags($string);

        if ($remove_breaks) {
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
        }

        return trim($string);
    }
}
