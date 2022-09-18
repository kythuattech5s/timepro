<?php

namespace App\Http\Controllers;

use App\Models\AskAndAnswer;
use Illuminate\Http\Request;

class AskAndAnswerController extends Controller
{
    public function ask(Request $request)
    {
        $validator = $this->validateAsk();

        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }

        $ask = new AskAndAnswer();
        $ask->map_table = $request->map_table;
        $ask->map_id = $request->map_id;
        $ask->content = $request->content;
        $ask->gender = $request->gender;
        $ask->phone = $request->phone;
        $ask->name = $request->name;
        $ask->act = 0;
        if (\Auth::check()) {
            $ask->user_id = \Auth::id();
        }
        $ask->save();
        return response([
            'code' => 200,
            'message' => 'Chúng tôi đã nhận được câu hỏi của bạn'
        ]);
    }

    private function validateAsk()
    {
        $request = request();
        return \Validator::make($request->all(), [
            'name' => ['required'],
            'phone' => ['required'],
            'content' => ['required'],
            'map_table' => ['required'],
            'map_id' => ['required'],
            'gender' => ['required'],
        ], [
            'required' => ':attribute ít nhất ký tự',
        ], [
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'content' => 'Nội dung',
            'map_table' => 'Bảng',
            'map_id' => 'Khóa học',
            'gender' => 'Giới tính',
        ]);
    }

    public function like(Request $request)
    {
        if (!\Auth::check()) {
            return response([
                'code' => 300,
                'message' => 'Vui lòng đăng nhập để thực hiện hành động này'
            ]);
        }
        $ask = AskAndAnswer::find($request->ask_and_answer_id);
        if ($ask == null) {
            return response([
                'code' => 100,
                'message' => 'Câu hỏi không tồn tại'
            ]);
        }

        $like = \DB::table('ask_and_answer_user')->where('ask_and_answer_id', $ask->id)->where('user_id', \Auth::id())->first();
        if ($like == null) {
            \DB::table('ask_and_answer_user')->insert([
                'ask_and_answer_id' => $ask->id,
                'user_id' => \Auth::id()
            ]);
            return response([
                'code' => 200,
                'message' => 'Đã yêu thích câu hỏi'
            ]);
        }

        \DB::table('ask_and_answer_user')->where('ask_and_answer_id', $ask->id)->where('user_id', \Auth::id())->delete();
        return response([
            'code' => 100,
            'message' => 'Bỏ yêu thích câu hỏi'
        ]);
    }

    public function replyAsk(Request $request)
    {
        if (!\Auth::check()) {
            return response([
                'code' => 100,
                'message' => 'Vui lòng đăng nhập để thực hiện hành động này'
            ]);
        }
        $validator = $this->validateReply();

        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }
        $ask = AskAndAnswer::find($request->input('ask_and_answer_id'));
        if ($ask == null) {
            return response([
                'code' => 100,
                'message' => 'Câu hỏi không tồn tại'
            ]);
        }

        $askRep = new AskAndAnswer();
        $askRep->map_table = $ask->map_table;
        $askRep->map_id = $ask->map_id;
        $askRep->content = $request->input('content');
        $askRep->act = 0;
        $askRep->ask_and_answer_id = $ask->id;
        $askRep->user_id = \Auth::id();
        $askRep->user_type = \Auth::user()->user_type_id;
        $askRep->save();

        return response([
            'code' => 200,
            'message' => 'Trả lời câu hỏi thành công'
        ]);
    }

    private function validateReply()
    {
        $request = request();
        return \Validator::make($request->all(), [
            'ask_and_answer_id' => ['required'],
            'content' => ['required']
        ], [
            'required' => 'Vui lòng chọn hoặc nhập :attribute',
        ], [
            'ask_and_answer_id' => 'Câu hỏi',
            'content' => 'Nội dung',
        ]);
    }
}
