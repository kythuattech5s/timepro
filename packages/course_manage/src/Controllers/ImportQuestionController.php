<?php
namespace CourseManage\Controllers;

use App\Helpers\MediaHelper;
use App\Models\QuestionImportLog;
use multiplechoicequestions\managequestion\Models\QuestionGroup;
use vanhenry\manager\controller\BaseAdminController;
class ImportQuestionController extends BaseAdminController
{
    public function import()
    {
        $listQuestionGroup = QuestionGroup::get();
        $listQuestionImportLog = QuestionImportLog::orderBy('id','desc')->paginate(10);
        return view('vh::imports.view',compact('listQuestionGroup','listQuestionImportLog'));
    }
    public function doImport()
    {
        $request = request();
        $questionGroup = QuestionGroup::find($request->question_group ?? 0);
        if (!isset($questionGroup)) {
            return response()->json([
                'code' => 100,
                'message' => 'Vui lòng chọn nhóm câu hỏi'
            ]);
        }
        if (!isset($request->file_excel)) {
            return response()->json([
                'code' => 100,
                'message' => 'Vui lòng nhập file excel'
            ]);
        }
        $questionImportLog = new QuestionImportLog;
        $questionImportLog->note = $request->note ?? '';
        $questionImportLog->question_group_id = $questionGroup->id;
        $questionImportLog->excel_file = MediaHelper::uploadFile('file_excel','import/questions');
        $questionImportLog->doImportItem();
        $questionImportLog->save();
        return response()->json([
            'code' => 200,
            'message' => 'Import câu hỏi thành công'
        ]);
    }
}