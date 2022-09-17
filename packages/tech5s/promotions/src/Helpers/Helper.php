<?php
namespace Tech5s\Promotion\Helpers;
class Helper
{
	public static function extractJson($json,$isArray = true,$def = []) {
        json_decode($json);
        if (json_last_error() != JSON_ERROR_NONE) return $def;
        return $isArray ? json_decode($json,true):json_decode($json);
    }
}