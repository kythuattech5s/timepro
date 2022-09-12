<?php
namespace multiplechoicequestions\managequestion\Helpers;
class QuestionHelper
{
    public static function isMobile()
    {
        $detect = new Mobile_Detect;
        return $detect->isMobile();
    }
    public static function extractJson($json,$isArray = true,$def = []) {
        if ($json == '') return $def;
        json_decode($json);
        if (json_last_error() != JSON_ERROR_NONE) return $def;
        return $isArray ? json_decode($json,true):json_decode($json);
    }
    public static function convertContentCustomerMathBuild($content)
    {
        preg_match_all( '/\*(.+?)\*/', $content,$allPhanSo);
        foreach($allPhanSo as $itemPhanSos){
            foreach ($itemPhanSos as $itemPhanSo) {
                if (strpos($itemPhanSo, '*phanso') !== false) {
                    $itemPhanSoNew = str_replace('*phanso','<span class="custom-math-fraction-content"><span class="fraction-content"><span class="content-wrapper">',$itemPhanSo);
                    $itemPhanSoNew = str_replace('*','</span></span></span>',$itemPhanSoNew);
                    $content = str_replace($itemPhanSo,$itemPhanSoNew,$content);
                }
            }
        }
        return $content;
    }
    public static function replaceFillAnswerContentPreview($content,$size)
    {
        if($content == '') return $content;
        $content = self::convertContentCustomerMathBuild($content);
        preg_match_all( '/\[(.+?)\]/', $content,$allInput);
        foreach($allInput as $itemInputs){
            foreach ($itemInputs as $itemInput) {
                if (strpos($itemInput, '[input_fill_answer') !== false) {
                    $key = str_replace('[','',$itemInput);
                    $key = str_replace(']','',$key);
                    $inputId = '<span class="input-content-box"><input type="text" class="input_fill_answer" size="'.$size.'" id="'.$key.'"></span>';
                    $content = str_replace($itemInput,$inputId,$content);
                }
            }
        }
        return $content;    
    }
    public static function replaceFillAnswerContent($content,$listInput)
    {
        if($content == '') return $content;
        $content = self::convertContentCustomerMathBuild($content);
        preg_match_all( '/\[(.+?)\]/', $content,$allInput);
        foreach($allInput as $itemInputs){
            foreach ($itemInputs as $itemInput) {
                if (strpos($itemInput, '[input_fill_answer') !== false) {
                    $key = str_replace('[','',$itemInput);
                    $key = str_replace(']','',$key);
                    $size = isset($listInput[$key]) ? (int)strlen($listInput[$key])+1:5;
                    $inputId = '<span class="input-content-box"><input type="text" class="input_fill_answer" size="'.$size.'" id="'.$key.'"></span>';
                    $content = str_replace($itemInput,$inputId,$content);
                }
            }
        }
        return $content;    
    }
    public static function replaceFillAnswerResultTrueAnswer($content,$listInput)
    {
        if($content == '') return $content;
        $content = self::convertContentCustomerMathBuild($content);
        preg_match_all( '/\[(.+?)\]/', $content,$allInput);
        foreach($allInput as $itemInputs){
            foreach ($itemInputs as $itemInput) {
                if (strpos($itemInput, '[input_fill_answer') !== false) {
                    $key = str_replace('[','',$itemInput);
                    $key = str_replace(']','',$key);
                    $value =  isset($listInput[$key]) ? $listInput[$key]:'';
                    $inputId = '<span class="input-content-box"><span class="fill_answer_resutl_box"> '.$value.' </span></span>';
                    $content = str_replace($itemInput,$inputId,$content);
                }
            }
        }
        return $content;    
    }
    public static function replaceFillAnswerResult($content,$listInput,$listAnswer)
    {
        if($content == '') return $content;
        $content = self::convertContentCustomerMathBuild($content);
        preg_match_all( '/\[(.+?)\]/', $content,$allInput);
        foreach($allInput as $itemInputs){
            foreach ($itemInputs as $itemInput) {
                if (strpos($itemInput, '[input_fill_answer') !== false) {
                    $key = str_replace('[','',$itemInput);
                    $key = str_replace(']','',$key);
                    $valueAnswer = isset($listAnswer[$key]) ? $listAnswer[$key]:'';
                    $value =  isset($listInput[$key]) ? $listInput[$key]:'';
                    $classStatus = $valueAnswer == $value ? 'success':'false';
                    $inputId = '<span class="input-content-box"><span class="fill_answer_resutl_box '.$classStatus.'"> '.$valueAnswer.' </span></span>';
                    $content = str_replace($itemInput,$inputId,$content);
                }
            }
        }
        return $content;    
    }
    
    public static function replaceDragDropContent($content,$listInput,$questionId)
    {
        if($content == '') return $content;
        $content = self::convertContentCustomerMathBuild($content);
        preg_match_all( '/\[(.+?)\]/', $content,$allInput);
        foreach($allInput as $itemInputs){
            foreach ($itemInputs as $itemInput) {
                if (strpos($itemInput, '[input_fill_answer') !== false) {
                    $key = str_replace('[','',$itemInput);
                    $key = str_replace(']','',$key);
                    $size = isset($listInput[$key]) ? (int)strlen($listInput[$key])+1:5;
                    $inputId = '<span class="basic_drop_re basic_drop_'.$questionId.'  ui-droppable" id="'.$key.'" inx="'.$questionId.'"></span>';
                    $content = str_replace($itemInput,$inputId,$content);
                }
            }
        }
        $htmlboxDefaulValue = '<div class="basic_drop_drag basic_sentence_re_drag" inx="'.$questionId.'">';
        shuffle($listInput);
        $count = 0;
        foreach ($listInput as $item) {
            $htmlboxDefaulValue .= vsprintf('<div class="basic_sentence_item basic_sentence_item_%s" inx="%s">
                    <span class="basic_drag basic_drag_re basic_drag_%s ui-draggable ui-draggable-handle" inx_ques="%s" inx="%s" drag="%s">%s</span>
                    <span class="basic_drag basic_drag_static basic_static_%s" inx="%s" drag="%s">%s</span>
                </div>',[$questionId,$count,$questionId,$questionId,$count,$item,$item,$questionId,$count,$item,$item]);
            $count++;
        }
        $htmlboxDefaulValue .= '</div>';
        return '<div class="basic_sentence_reorganizing">'.$htmlboxDefaulValue.'<div class="basic_drop_drag basic_sentence_re_drop basic_elm" tpl="sentence_reorder" inx="'.$questionId.'">'.$content.'</div></div>';    
    }
    public static function replaceDragDropResult($content,$listInput,$listAnswer,$questionId)
    {
        if($content == '') return $content;
        $content = self::convertContentCustomerMathBuild($content);
        preg_match_all( '/\[(.+?)\]/', $content,$allInput);
        foreach($allInput as $itemInputs){
            foreach ($itemInputs as $itemInput) {
                if (strpos($itemInput, '[input_fill_answer') !== false) {
                    $key = str_replace('[','',$itemInput);
                    $key = str_replace(']','',$key);
                    $valueAnswer = isset($listAnswer[$key]) ? $listAnswer[$key]:'';
                    $value =  isset($listInput[$key]) ? $listInput[$key]:'';
                    $classStatus = $valueAnswer == $value ? 'success':'false';
                    $inputId = '<span class="input-content-box"><span class="fill_answer_resutl_box '.$classStatus.'"> '.$valueAnswer.' </span></span>';
                    $content = str_replace($itemInput,$inputId,$content);
                }
            }
        }
        $htmlboxDefaulValue = '<div class="basic_drop_drag basic_sentence_re_drag" inx="'.$questionId.'">';
        shuffle($listInput);
        $count = 0;
        foreach ($listInput as $item) {
            $htmlboxDefaulValue .= vsprintf('<div class="basic_sentence_item basic_sentence_item_%s" inx="%s">
                    <span class="basic_drag basic_drag_re basic_drag_%s ui-draggable ui-draggable-handle no_drag" inx_ques="%s" inx="%s" drag="%s">%s</span>
                    <span class="basic_drag basic_drag_static basic_static_%s no_drag" inx="%s" drag="%s">%s</span>
                </div>',[$questionId,$count,$questionId,$questionId,$count,$item,$item,$questionId,$count,$item,$item]);
            $count++;
        }
        $htmlboxDefaulValue .= '</div>';
        return $htmlboxDefaulValue.$content;    
    }
}