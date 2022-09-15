<?php

namespace Roniejisa\Helpers;

use vanhenry\manager\model\VRoute;

class GenerateSlug
{
    public static function getSlug($name)
    {
        $check = VRoute::where('vi_link', $name)->first();
        $number = 1;
        while (!is_null($check)) {
            $fileName = \Str::slug($name);
            $checkSeparator = explode('-', $fileName);
            $checkHasNumberFile = is_numeric($checkSeparator[count($checkSeparator) - 1]) ? count($checkSeparator) - 1 : null;
            if (is_numeric($checkHasNumberFile)) {
                unset($checkSeparator[$checkHasNumberFile]);
            }
            $fileName = implode('-', $checkSeparator);
            $name = $fileName . '-' . $number;
            $check = VRoute::where('vi_link', $name)->first();
            $number++;
        }
        return $name;
    }

    public static function generateCode($model, $code, $tag = '')
    {   
        $check = $model::where('code', $code)->first();
        while ($check != null || empty($code)) {
            $code = $tag . \Str::random(8);
            $check = $model::where('code', $code)->first();
        }
        return $code;
    }
}
