<?php

namespace Roniejisa\Comment\Controllers;

use App\Http\Controllers\Controller;
use Roniejisa\Comment\Models\Order;
use Roniejisa\Comment\Models\Product;
use Auth;
use Roniejisa\Comment\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    public function show(Request $request)
    {
        return view('commentRS::view');
    }

    public function shopReplyComment(Request $request)
    {
        $comment = Helper::repCommentShop($request);
        return response([
            'code' => 200,
            'message' => 'Đã trả lời bình luận thành công',
            'replyComment' => 1,
            'id' => $request->input('comment_id'),
        ]);
    }

    public function showComment(Request $request, $id)
    {
        $comment = Helper::getComment($id);
        return response([
            'code' => 200,
            'html' => view('commentRS::shop.detail', compact('comment'))->render(),
        ]);
    }

    public function commentNow(Request $request)
    {
        if (!Auth::check() && config('cmrsc_comment.checkUser', false)) {
            return response([
                'code' => 100,
                'message' => 'Vui lòng đăng nhập',
                'redirect_url' => url('dang-nhap'),
            ]);
        }

        $comment = Helper::addComment($request);

        if (is_array($comment)) {
            return response($comment);
        }

        if ($comment->act == 0) {
            return response([
                'code' => 200,
                'message' => 'Đã bình luận thành công',
            ]);
        }

        $response = [
            'code' => 200,
            'plusCount' => true,
            'html' => view('commentRS::item', compact('comment'))->render(),
            'message' => 'Bình luận và dánh giá thành công',
        ];

        if (config('cmrsc_comment.hasShowTotal')) {
            // if ($request->input('map_table') == 'products') {
            //     $ratings = Product::where('id', $request->input('map_id'))->first()->getRating();
            // }
            $ratings = [
                'scoreAll' => 5,
                'percentAll' => 10,
                'totalRating' => 1,
                'percentFiveStar' => 2,
                'percentFourStar' => 2,
                'percentThreeStar' => 2,
                'percentTwoStar' => 2,
                'percentOneStar' => 2,
                'percentFiveStar' => 2,
                'oneStar' => 2,
                'twoStar' => 3,
                'threeStar' => 4,
                'fourStar' => 5,
                'fiveStar' => 6,
            ];
            $response['total_html'] = view('commentRS::box_percent', compact('ratings'))->render();
        }

        return response($response);
    }


    public function repCommentNow(Request $request)
    {
        if (!Auth::check() && config('cmrsc_comment.checkUser', false)) {
            return response([
                'code' => 100,
                'message' => 'Vui lòng đăng nhập',
                'redirect_url' => url('dang-nhap'),
            ]);
        }

        $commentChild = Helper::addComment($request, config('cmrsc_comment.checkShop'));

        if (is_array($commentChild)) {
            return response($commentChild);
        }

        if ($commentChild->act == 0) {
            return response([
                'code' => 200,
                'message' => 'Đã trả lời bình luận thành công',
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Trả lời bình luận thành công',
            'html' => view('commentRS::comment_child', compact('commentChild'))->render(),
        ]);
    }

    public function ratingOrder(Request $request)
    {
        $order = Order::where('id', $request->input('id', $request->input('order_id')))->where('user_id', Auth::id())->first();
        if ($order == null) {
            abort(404);
        }
        if ($request->isMethod("POST")) {
            $comment = Helper::addCommentAndRatingOrder($request);

            if (is_array($comment)) {
                return response($comment);
            }

            return response([
                'code' => 200,
                'message' => 'Bình luận đơn hàng thành công',
            ]);
        }

        return response([
            'code' => 200,
            'html' => view('commentRS::order.rating_order', compact('order'))->render(),
        ]);
    }

    public function likeAndUnlike(Request $request)
    {
        return Helper::likeAndUnlike($request);
    }

    public function fetchCommentChild(Request $request)
    {
        return Helper::fetchCommentChild($request);
    }

    public function fetchCommentMore(Request $request)
    {
        return Helper::fetchCommentMore($request);
    }

    public function filterRating(Request $request)
    {
        return Helper::filterRating($request);
    }

    public function file($source, $filename)
    {
        $path = config('comment.path') . $source . '/' . $filename;
        $fullPath = base_path() . $path;
        $mime = File::mimeType($fullPath);
        $pathinfo = pathinfo($fullPath);

        if ($mime == 'text/plain' && $pathinfo['extension'] == 'css') {
            $mime = 'text/css';
        }

        ob_end_clean();
        return response()->file($fullPath, [
            "Content-Type" => $mime,
            "path-link" => $path,
            "cache-control" => "public, max-age=31536000, s-maxage=31536000, immutable",
        ]);
    }

    public function onlyRating(Request $request)
    {
        Helper::addRating($request);
        event('comment.build.data', [$request->input('map_table'), $request->input('map_id')]);
        session()->put('user_rating_' . $request->input('map_id'), $request->input('rate'));
        return response([
            'code' => 200,
            'message' => 'Đánh giá thành công',
        ]);
    }
}
