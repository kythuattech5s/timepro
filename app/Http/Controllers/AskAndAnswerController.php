<?php

namespace App\Http\Controllers;

use DateTime;
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
        $model = $request->input('model');
        $data = [
            'map_table' => $request->map_table,
            'map_id' => $request->map_id,
            'content' => $request->content,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
            'act' => 0
        ];

        if (isset($request->phone)) {
            $data['phone'] =  $request->phone;
        }
        if (isset($request->name)) {
            $data['name'] =  $request->name;
        }
        if (isset($request->gender)) {
            $data['gender'] =  $request->gender;
        }

        if (\Auth::check()) {
            $data['user_id'] = \Auth::id();
            $data['user_type_id'] = \Auth::user()->user_type_id;
        }
        $model::insert($data);

        return response([
            'code' => 200,
            'message' => 'Chúng tôi đã nhận được ' . $request->input('label') . ' của bạn'
        ]);
    }

    private function validateAsk()
    {
        $request = request();
        $data = [
            'name' => $request->input('name', null) !== null ? ['required'] : [],
            'phone' => $request->input('phone', null) !== null ? ['required'] : [],
            'content' => ['required'],
            'map_table' => ['required'],
            'map_id' => ['required'],
            'gender' => $request->input('phone', null) !== null ? ['required'] : [],
        ];
        return \Validator::make($request->all(), $data, [
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
        $model = $request->input('model');
        $oldData = $model::where('id', $request->input('id'))->first();
        if ($oldData == null) {
            return response([
                'code' => 100,
                'message' => 'Câu hỏi không tồn tại'
            ]);
        }

        $like = \DB::table($request->input('table_like'))->where($request->input('field_main'), $oldData->id)->where('user_id', \Auth::id())->first();
        if ($like == null) {
            \DB::table($request->input('table_like'))->insert([
                $request->input('field_main') => $oldData->id,
                'user_id' => \Auth::id()
            ]);
            return response([
                'code' => 200,
                'message' => 'Đã yêu thích câu hỏi'
            ]);
        }

        \DB::table($request->input('table_like'))->where($request->input('field_main'), $oldData->id)->where('user_id', \Auth::id())->delete();
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
        $model = $request->input('model');

        $dataOld = $model::where('id', $request->input('id'))->first();
        if ($dataOld == null) {
            return response([
                'code' => 100,
                'message' => 'Câu hỏi không tồn tại'
            ]);
        }

        $data = [
            'map_table' => $dataOld->map_table,
            'map_id' => $dataOld->map_id,
            'content' => $request->content,
            $request->input('field_main') => $dataOld->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
            'act' => 0
        ];

        if (isset($request->phone)) {
            $data['phone'] =  $request->phone;
        }
        if (isset($request->name)) {
            $data['name'] =  $request->name;
        }
        if (isset($request->gender)) {
            $data['gender'] =  $request->gender;
        }

        if (\Auth::check()) {
            $data['user_id'] = \Auth::id();
            $data['user_type_id'] = \Auth::user()->user_type_id;
        }
        $model = $request->input('model');
        $model::insert($data);

        return response([
            'code' => 200,
            'message' => 'Trả lời câu hỏi thành công'
        ]);
    }

    private function validateReply()
    {
        $request = request();
        return \Validator::make($request->all(), [
            'id' => ['required'],
            'content' => ['required']
        ], [
            'required' => 'Vui lòng chọn hoặc nhập :attribute',
        ], [
            'id' => $request->input('label'),
            'content' => 'Nội dung',
        ]);
    }

    public function loadMoreAsk(Request $request)
    {
        $model = $request->input('model');
        $with = $request->input('with');
        $asks = $model::with(explode(',', $with))->where('map_table', $request->input('map_table'))->where('map_id', $request->input('map_id'))->where('act', 1)->orderBy('id', 'DESC')->paginate(5);
        return response([
            'code' => 200,
            'html' => view('courses.components.ask_item', compact('asks'))->render(),
            'isLastPage' => $asks->onLastPage()
        ]);
    }
}
