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
        if (\Auth::check()) {
            $ask->user_id = \Auth::id();
        }
        $ask->save();
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
            'required' => ':attribute ít nhất :min ký tự',
        ], [
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'content' => 'Nội dung',
            'map_table' => 'Bảng',
            'map_id' => 'Khóa học',
            'gender' => 'Giói tính',
        ]);
    }
}
