<?php
namespace multiplechoicequestions\managequestion\Controllers;
use multiplechoicequestions\managequestion\Factories\QuestionFactory;
use multiplechoicequestions\managequestion\Models\Question as QuestionModel;
use multiplechoicequestions\managequestion\Helpers\QuestionHelper;
class ManageQuestionController extends Controller
{
	private $questionFactory;
	public function __construct()
	{
		$this->questionFactory = new QuestionFactory;
	}
	public function loadQuestionContentAdmin()
	{
		$type = request()->group ?? 0;
		$value = request()->value ?? 0;
		$nameField = request()->nameField ?? 0;
		$question = $this->questionFactory->get($type);
		return $question->getQuestionContentAdmin($value,$nameField);
	}
	public function loadListQuestionAdmin()
	{
		$search = request()->q ?? null;
		// if (!isset($search)) {
		// 	return 'Vui lòng nhập Tên, Mã hoặc Ghi chú câu hỏi trắc nghiêm.';
		// }
		$type = request()->type ?? null;
		$currentItemId = request()->currentItem ?? 0;
		$defaultData = request()->defaultData ?? '';
		$defaultData = json_decode($defaultData,true);
		$defaultData = @$defaultData ?? array();
		$listDefaultItemQuestion = \DB::table($defaultData['pivot_table'])->where($defaultData['origin_field'],$currentItemId)->pluck($defaultData['target_field'])->all();
		$listQuestion = QuestionModel::when($search, function ($q, $search) {
                                    	$q->where(function($q) use ($search){
                                    		$q->where('name','like','%'.$search.'%')
                                    			->orWhere('code','like','%'.$search.'%')
                                    			->orWhere('note','like','%'.$search.'%');
                                    	});
                                	})->when($type, function ($q, $type) {
                                    	$q->whereHas('questionGroup',function($q) use($type){
											$q->where('question_groups.id',$type);
										});
                                	})->whereNotIn('id',$listDefaultItemQuestion)->limit(100)->get();
        return view('mtc::question.list_question',compact('listQuestion'));
	}
	public function insertListQuestion()
	{
		$currentItemId = request()->currentItem ?? 0;
		$listValue = request()->listValue ?? '';
		$defaultData = request()->defaultData ?? '';
		$listValue = trim($listValue,',');
		if ($listValue == '') {
			return response()->json(['code'=>100,'message'=>'Không tìm thấy câu hỏi nào']);
		}
		$arrId = explode(',', $listValue);
		$defaultData = json_decode($defaultData,true);
		$defaultData = @$defaultData ?? array();
		$dataInsert = [];
		foreach ($arrId as $itemId) {
			$dataAdd = [];
			$dataAdd[$defaultData['origin_field']] = $currentItemId;
			$dataAdd[$defaultData['target_field']] = $itemId;
			$dataAdd['created_at'] = now();
			$dataAdd['updated_at'] = now();
			array_push($dataInsert,$dataAdd);
		}
		if (count($dataInsert) > 0) {
			\DB::table($defaultData['pivot_table'])->insert($dataInsert);
		}
		return response()->json(['code'=>200,'message'=>'Thêm câu hỏi thành công']);
	}
	public function deleteQuestionPivot()
	{
		$currentItemId = request()->currentItem ?? 0;
		$defaultData = request()->defaultData ?? '';
		$target = request()->target ?? 0;
		$defaultData = json_decode($defaultData,true);
		$defaultData = @$defaultData ?? array();
		$ret = \DB::table($defaultData['pivot_table'])->where($defaultData['origin_field'],$currentItemId)->where($defaultData['target_field'],$target)->delete();
		if ($ret) {
			return response()->json(['code'=>200,'message'=>'Xóa thành công']);
		}else{
			return response()->json(['code'=>100,'message'=>'Đã có lỗi xảy ra']);
		}
	}
	public function updateQuestionPivot()
	{
		$currentItemId = request()->currentItem ?? 0;
		$defaultData = request()->defaultData ?? '';
		$defaultData = json_decode($defaultData,true);
		$defaultData = @$defaultData ?? array();
		$infoQuestion = request()->infoQuestion ?? '';
		$infoQuestion = json_decode($infoQuestion,true);
		$infoQuestion = @$infoQuestion ?? array();

		foreach ($infoQuestion as $item) {
			$dataUpdate = $item;
			unset($dataUpdate['id_target']);
			\DB::table($defaultData['pivot_table'])->where($defaultData['origin_field'],$currentItemId)
													->where($defaultData['target_field'],$item['id_target'])
													->update($dataUpdate);
		}
		return response()->json(['code'=>200,'message'=>'Cập nhật thành công']);
	}
	
	public function updateMatchQuestionPivot()
	{
		$currentItemId = request()->currentItem ?? 0;
		$defaultData = request()->defaultData ?? '';
		$defaultData = json_decode($defaultData,true);
		$defaultData = @$defaultData ?? array();
		$infoQuestion = request()->infoQuestion ?? '';
		$infoQuestion = json_decode($infoQuestion,true);
		$infoQuestion = @$infoQuestion ?? array();

		foreach ($infoQuestion as $item) {
			$dataUpdate = $item;
			unset($dataUpdate['id_target']);
			\DB::table($defaultData['pivot_table'])->where($defaultData['origin_field'],$currentItemId)
													->where($defaultData['target_field'],$item['id_target'])
													->update($dataUpdate);
		}
		return response()->json(['code'=>200,'message'=>'Cập nhật thành công']);
	}
	public function buildMathAdditionSubtractionMultiplication()
	{
		$line1 = request()->line1 ?? '';
		$line2 = request()->line2 ?? '';
		$line3 = request()->line3 ?? '';
		$operator = request()->operator ?? '';
		$arrLine1 = $line1 != '' ? explode('|', trim($line1,'|')):[];
		$arrLine2 = $line2 != '' ? explode('|', trim($line2,'|')):[];
		$arrLine3 = $line3 != '' ? explode('|', trim($line3,'|')):[];
		$maxSize = 1;
		$html = view('mtc::admin.custom_math.addition_subtraction_multiplication_resutl',compact('arrLine1','arrLine2','arrLine3','operator','maxSize'))->render();
		$htmlPreview = QuestionHelper::replaceFillAnswerContentPreview($html,$maxSize);
		return response()->json([
			'html' => $htmlPreview,
			'html_copy' => htmlentities($html)
		]);
	}
	public function buildMathNumberConcatenation()
	{
		$strVal = request()->strVal ?? '';
		$arrVal = explode('|',trim($strVal,'|'));
		$html = view('mtc::admin.custom_math.number_concatenation',compact('arrVal'))->render();
		$htmlPreview = QuestionHelper::replaceFillAnswerContentPreview($html,5);
		return response()->json([
			'html' => $htmlPreview,
			'html_copy' => htmlentities($html)
		]);
	}
}