<?php
namespace Roniejisa\Comment\Controllers;

use Roniejisa\Comment\Helpers\Helper;
use Roniejisa\Comment\Models\Comment;
use Illuminate\Http\Request;
use vanhenry\manager\controller\BaseAdminController;

class CommentAdminController extends BaseAdminController
{
    public function detailComment(Request $request)
    {
        $id = $request->input('id');
        $comment = Comment::find($id);
        if ($comment->parent != 0) {
            $comment = Comment::find($comment->parent);
        }
        if ($comment == null) {
            return redirect()->back()->with(['typeNotify' => 'danger', 'messageNotify' => 'Bình luận này hiện tại đã bị xóa']);
        }
        return view('commentRS::comments.detail_comment', compact('comment'));
    }
    public function repComment(Request $request)
    {
        if (trim($request->content) == '' || empty($request->content)) {
            return response()->json([
                'code' => 100,
                'message' => 'Vui lòng nhập bình luận của bạn',
            ]);
        }
        $parent = $this->getParent($request->parent);
        $comment = new Comment;
        $comment->map_id = $parent->map_id;
        $comment->map_table = $parent->map_table;
        $comment->content = $request->content;
        $comment->parent = $request->parent;
        $comment->is_admin = 1;
        $comment->act = 1;
        $comment->save();
        return response()->json([
            'code' => 200,
            'message' => 'Đã trả lời bình luận thành công',
        ]);
    }
    public function getParent($id)
    {
        return Comment::find($id);
    }
    public function fetchComment($id)
    {
        $comment = Comment::find($id);
        if ($comment->parent != 0) {
            $comment = Comment::find($comment->parent);
        }
        $view = view('vh::view.comments.item_comment', compact('comment'))->render();
        return response()->json(['view' => $view]);
    }
    public function changeAct(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->act = $request->act;
        $comment->save();
        
        $rating = $comment->rating;
        if($rating != null){
            $rating->act = $request->act;
            $rating->save();
        }
        if ($request->act == 1) {
            $data = ['code' => 200, 'message' => 'Đã hiển thị bình luận'];
        } else {
            $data = ['code' => 100, 'message' => 'Đã ẩn bình luận'];
        }
        Helper::buildDataRating($comment->map_table, $comment->map_id);
        return response()->json($data);
    }
}
