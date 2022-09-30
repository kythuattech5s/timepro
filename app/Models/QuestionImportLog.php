<?php
namespace App\Models;

use Illuminate\Support\Collection;
use multiplechoicequestions\managequestion\Models\Question;
use multiplechoicequestions\managequestion\Models\QuestionGroup;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Support;

class QuestionImportLog extends BaseModel
{
    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class,'question_group_id');
    }
    public function toCollection(Worksheet $sheet)
    {
        $collect = new Collection;
        foreach ($sheet->getRowIterator() as $key => $row) {
            $collect[$key] = new Collection;
            foreach ($row->getCellIterator() as $cell) {
                $column = $cell->getParent()->getCurrentCoordinate();
                $value = $cell->getValue();
                $collect[$key][$column] = $value;
            }
        }
        $collectNull = $collect->filter(function ($q) {
            return $q == $q->filter(function ($value) {
                return $value == null;
            });
        });
        $collection = $collect->filter(function ($q, $key) use ($collectNull) {
            return !$collectNull->keys()->contains($key);
        });
        return $collection;
    }
    public function groupCollection(Spreadsheet $sheets, int $sheetIndex, array $arraySpecial = [])
    {
        $collection = $this->toCollection($sheets->getSheet($sheetIndex));
        $field = $collection[1];
        $field = $field->values();
        $collection = $collection->filter(function ($q, $key) {
            return $key !== 1;
        });
        $newCollection = new Collection;
        $i = 0;
        foreach ($collection as $key => $data) {
            $newCollection[$i] = new Collection;
            $a = 0;
            foreach ($data as $key => $value) {
                if (in_array($field[$a], $arraySpecial)) {
                    if (!isset($newCollection[$i][$field[$a]])) {
                        $newCollection[$i][$field[$a]] = new Collection;
                    }
                    if ($value !== null) {
                        $newCollection[$i][$field[$a]][] = [
                            'column' => $key,
                            'value' => $value
                        ];
                    }
                } else {
                    $newCollection[$i][$field[$a]] = [
                        'column' => $key,
                        'value' => $value
                    ];
                }
                $a++;
            }
            $i++;
        }
        return $newCollection;
    }
    public function doImportItem()
    {
        $fileExcelInfo = Support::extractJson($this->excel_file);
        if (!isset($fileExcelInfo['path']) || !isset($fileExcelInfo['file_name'])) {
            return false;
        }
        $excelFilePath = $fileExcelInfo['path'].$fileExcelInfo['file_name'];
        if (!file_exists(public_path($excelFilePath))) {
            return false;
        }
        $sheets = IOFactory::load(public_path($excelFilePath));
        $collect = $this->groupCollection($sheets, 0);
        foreach ($collect as $item) {
            $itemValues = $item->values();
            $questionCode = $itemValues[2]['value'] ?? '';
            $oldQuestion = Question::where('code',$questionCode)->first();
            if (!isset($oldQuestion)) {
                $newQuestion = new Question;
                $newQuestion->name = $itemValues[1]['value'] ?? '';
                $newQuestion->code = $itemValues[2]['value'] ?? '';
                $newQuestion->question_content = $itemValues[3]['value'] ?? '';
                $newQuestion->note = $itemValues[4]['value'] ?? '';
                $newQuestion->explanation_guide = $itemValues[5]['value'] ?? '';
                $newQuestion->question_type_id = 1;
                $newQuestion->question_group_id = $this->question_group_id;;
                $newQuestion->question_import_log_id = $this->id;;
                $anwserString = $itemValues[6]['value'] ?? '';
                $arrAnwser = explode(PHP_EOL,$anwserString);
                $arrAnwser = array_map('trim', $arrAnwser);
                $dataAnwser = [];
                foreach ($arrAnwser as $itemAnwser) {
                    $dataAdd = [];
                    $anwserInfo = explode('||',$itemAnwser);
                    $anwserInfo = array_map('trim', $anwserInfo);
                    $dataAdd['file_audio'] = '';
                    $dataAdd['is_true'] = isset($anwserInfo[1]) && $anwserInfo[1] == 'Đúng' ? 1:0;
                    $dataAdd['content_question'] = $anwserInfo[0] ?? '';
                    array_push($dataAnwser,$dataAdd);
                }
                $newQuestion->content = json_encode($dataAnwser);
                $newQuestion->save();
            }
        }
        return true;
    }
}
