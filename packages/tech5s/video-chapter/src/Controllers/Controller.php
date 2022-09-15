<?php

namespace Tech5s\VideoChapter\Controllers;

use Illuminate\Http\Request;
use vanhenry\manager\model\VDetailTable;

class Controller
{
    public function __insertVideoChapter($pivots, $item)
    {
        $table = $item->getTable();
        foreach ($pivots as $key => $pivot) {
            $vdetail = VDetailTable::where(['parent_name' => $table, 'name' => $key])->first();
            if ($vdetail == null) {
                continue;
            }
            $default_data = json_decode($vdetail->default_data, true);
            $relationship = json_decode($vdetail->relationship, true);
            $dataPivot = json_decode($pivot, true);
            $fieldMain = $default_data['field_main'];
            $table = $relationship['data'][0]['table'];
            foreach ($relationship['data'] as $relation) {
                foreach ($dataPivot as $key => $pivot) {
                    $dataPivot[$key][$fieldMain] = $item->id;
                    $dataPivot[$key]['updated_at'] = new \Datetime();
                }
                \DB::table($table)->insert($dataPivot);
            }
        }
    }

    public function __updateVideoChapter($pivots, $item)
    {
        $table = $item->getTable();
        foreach ($pivots as $key => $pivot) {
            $vdetail = VDetailTable::where(['parent_name' => $table, 'name' => $key])->first();
            if ($vdetail == null) {
                continue;
            }
            $default_data = json_decode($vdetail->default_data, true);
            $relationship = json_decode($vdetail->relationship, true);
            $dataPivot = json_decode($pivot, true);
            $ids = array_map(function ($q) {
                return isset($q['id']) ? $q['id'] : null;
            }, $dataPivot);
            $ids = array_filter($ids);

            $fieldMain = $default_data['field_main'];
            $table = $relationship['data'][0]['table'];
            \DB::table($table)->where($fieldMain, $item->id)->whereNotIn('id', $ids)->delete();

            foreach ($relationship['data'] as $relation) {
                foreach ($dataPivot as $key => $pivot) {
                    $pivot[$fieldMain] = $item->id;
                    $pivot['updated_at'] = new \Datetime();
                    if (isset($pivot['id'])) {
                        \DB::table($table)->where($fieldMain, $item->id)->where('id',$pivot['id'])->update($pivot);
                    } else {
                        \DB::table($table)->insert($pivot);
                    }
                }
            }
        }
    }
}
