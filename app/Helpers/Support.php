<?php

namespace App\Helpers;

use App\Helpers\Media;
use App\Models\Menu;
use Carbon\Carbon;
use Currency;

class Support
{
    public static $menu;
    public static function extractJson($json, $isArray = true, $def = [])
    {
        json_decode($json);
        if (json_last_error() != JSON_ERROR_NONE) return $def;
        return $isArray ? json_decode($json, true) : json_decode($json);
    }
    public static function isDateTime($string, $format = 'Y-m-d H:i:s')
    {
        return \DateTime::createFromFormat($format, $string);
    }
    public static function showDate($string, $format = 'H:i d-m-Y', $formatIn)
    {
        if (self::isDateTime($string, $formatIn)) {
            return Carbon::parse($string)->format($format);
        }
    }
    public static function showDateTime($string, $format = 'H:i d-m-Y')
    {
        if (self::isDateTime($string)) {
            return Carbon::parse($string)->format($format);
        }
    }

    public static function show($object, $key, $def = '')
    {
        if (!is_object($object) && !is_array($object)) {
            return $def;
        }
        if (is_object($object)) {
            $value = isset($object->$key) ? $object->$key : $def;
        } else {
            $value = isset($object[$key]) ? $object[$key] : $def;
        }
        switch ($key) {
            case 'price':
            case 'price_old':
            case 'starting_price':
            case 'origin_price':
            case 'price_step':
            case 'subtotal':
            case 'priceTotal':
                return Currency::showMoney($value);
                break;
            case 'slug':
                return $value;
                break;
            case 'link':
                return self::language($value);
                break;
            default:
                return $value;
                break;
        }
    }

    public static function language($value)
    {
        if (\App::getLocale() == 'en') {
            return '/en' . '/' . $value;
        } else {
            return $value;
        }
    }

    public static function getMenuRecursive($group = null, int $take = null)
    {
        $menus = \Cache::rememberForever('MENU_GROUP_' . $group, function () use ($group, $take) {
            $menus = Menu::where('menu_category_id', $group)->where('parent', 0)->act()->ord()->with('recursiveChilds');
            if ($take != null) {
                return $menus->take($take)->get();
            }else{
                return $menus->get();
            }
        });
        return $menus;
    }

    public static function showMenuRecursive($menus)
    {
        if ($menus->count() > 0) {
            $addClass = '';
            if ($menus->count() > 10) {
                $addClass = 'big-menu';
            }
            echo '<ul class="' . $addClass . '">';
            foreach ($menus as $menu) {
                $active = url()->current() == url($menu->link) ? "active" : " ";
                echo '<li>';
                echo '<a href="' . $menu->link . '" title="' . \Support::show($menu, 'name') . '" class="' . $active . '" >';
                echo \Support::show($menu, 'name');
                echo '</a>';
                self::showMenuRecursive($menu->recursiveChilds);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

    public static function isLightHouseSp()
    {
        $agent = request()->header('User-Agent');
        preg_match('/Lighthouse/i', $agent, $outs);
        return count($outs) > 0;
    }

    public static function asset($file)
    {
        $file_path = public_path($file);

        if (file_exists($file_path)) {
            return asset($file) . '?v=' . filemtime($file_path);
        }
        else {
            $path = collect(get_headers(url($file)));

            $path = $path->first(function ($string) {
                return strpos($string, 'path-link') === 0;
            });
            if ($path) {
                $file_path = base_path() . str_replace('path-link: ', '', $path);
            }
            if (file_exists($file_path)) {
                return asset($file) . '?v=' . filemtime($file_path);
            } else {
                return asset($file) . '?v=2';
            }
        }
    }

    public static function numberFormat($number, $stringFormat = ',', $stringChange = '.')
    {
        if (is_null($number) || $number == '') {
            return 0;
        }
        return number_format($number, 0, $stringFormat, $stringChange);
    }

    public static function getAllChildLevel($model, string $field, string $field_parent, int $id, array $categoryIds = [])
    {
        $categoryIds[] = $id;
        $items = $model::where($field_parent, $id)->get();
        if ($items->count() > 0) {
            foreach ($items as $item) {
                $categoryIds = array_merge($categoryIds, self::getAllChildLevel($model, $field, $field_parent, $item->$field, []));
            }
        }
        return $categoryIds;
    }

    public static function URLPrevious(bool $isSet = true, string $defaultUrl = '/')
    {
        $key = 'PREVIOUS_URL_RS';
        if ($isSet) {
            $url = url()->previous();
            $url = strpos($url, url('/')) >= 0 ? $url : url($defaultUrl);
            session()->put($key, $url);
        }

        if (!$isSet) {
            $url = is_null(($url = session()->get($key))) ? url()->previous() : $url;
            $url = $url == url()->current() ? url($defaultUrl) : $url;
            session()->forget($key, null);
        }

        $arrayNotRedirect = ['.js', '.css', '_debugbar', 'javascript', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg'];
        foreach ($arrayNotRedirect as $error) {
            if (strpos($url, $error) !== false) {
                $url = url($defaultUrl);
                break;
            }
        }
        return $url;
    }

    public static function redirectTo($url, $code, $message)
    {
        return redirect()->to($url)->with('messageNotify', $message)->with('typeNotify', $code);
    }
    public static function sendResponse($code, $message = '', $url = null)
    {
        if (request()->ajax()) {
            session()->flash('typeNotify', $code);
            session()->flash('messageNotify', $message);
            return response()->json([
                'code'          => $code,
                'message'       => $message,
                'redirect_url'  => $url
            ]);
        } else {
            return static::redirectTo($url, $code, $message);
        }
    }

    public static function buildLinkPagination($urlDefault, $pageParam = false)
    {
        $params = request()->all();
        if ($pageParam) {
            $params['page'] = $pageParam;
        }
        $newParam = http_build_query($params);

        if ($newParam !== '') {
            $urlDefault .= '?' . $newParam;
        }
        return $urlDefault;
    }
    public static function printMenuCate($data, $activeId = 0, $parent = 0)
    {
        echo '<ul class="nav-new__cate font-bold 2xl:text-[1.125rem] mb-6">';
        foreach ($data as $k => $item) {
            $active = $activeId == $item->id ? 'active active_nav_pcate' : '';
            if ($item->parent == $parent) {
                $str = '<li class="mb-2 last:mb-0 px-4 ' . $active . '">
                                <a href="' . $item->slug . '" class="hover:text-[#252525]" title="' . $item->name . '">' . $item->name . '</a>';
                echo $str;
                self::printMenuCate($data, $activeId, $item->id);
                echo '</li>';
            }
        }
        echo '</ul>';
    }
    public static function generateSlug($tableMap, $slug, $key)
    {
        $num = 2;
        do {
            $item = \DB::table($tableMap)->select('id')->where(function ($q) use ($slug, $key) {
                $q->where([$key => $slug]);
            })->first();
            if ($item != null) {
                $slug .= '-' . $num;
            } else {
                return $slug;
            }
        } while (true);
    }
    public static function settingExcel($event)
    {
        $default_font_style = [
            'font' => ['name' => 'Arial', 'size' => 12],
        ];
        $heading = [
            'font' => ['bold' => true],
        ];
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Reader\Xls\Style\Border::lookup(0x01),
                ],
            ],
        ];
        $active_sheet = $event->sheet->getDelegate();
        $column = $active_sheet->getColumnDimensions();
        $columnHeading = "A1:" . end($column)->getColumnIndex() . '1';
        $cells = $active_sheet->getActiveCell() . ':' . $active_sheet->getCellCollection()->getCurrentCoordinate();
        $active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);
        $active_sheet->getStyle($cells)->applyFromArray($styleArray);
        $active_sheet->getStyle($columnHeading)->applyFromArray($heading);
    }
    public static function getYoutubeId($link)
    {
        if ($link == '') return 0;
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $link, $matches);
        if (isset($matches[1]) && $matches[1] != "") {
            return $matches[1];
        } else {
            return 0;
        }
    }
    public static function exeCurl($url, $type = 'GET', $data = null, $headers = [])
    {
        $curl = curl_init();
        $params = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_FOLLOWLOCATION => 0, // 0 cho phép redirect theo nếu link curl đích bị redirect
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );
        if ($type == 'POST' && is_string($data)) {
            $params[CURLOPT_POSTFIELDS] = $data;
        }
        if ($type == 'POST' && is_array($data)) {
            $params[CURLOPT_POSTFIELDS] = http_build_query($data);
        }
        if ($type == 'GET' && is_array($data)) {
            $params[CURLOPT_URL] = $url . '?' . http_build_query($data);
        }
        if ($headers) {
            $params[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($curl, $params);
        $res = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if (!empty($err)) {
            return $err;
        }
        return $res;
    }
}
