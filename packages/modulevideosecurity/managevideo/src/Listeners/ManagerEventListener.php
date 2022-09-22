<?php 
namespace modulevideosecurity\managevideo\Listeners;
use \vanhenry\manager\model\Media;
class ManagerEventListener
{
    public function subscribe($events)
    {
        $events->listen('vanhenry.manager.delete.success', function ($table, $id)
        {
            $tableMap = $table;
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                $tableMap = $table->table_map;
            }
            $id = is_array($id) ? implode(",", $id) : $id;
            \VideoSetting::catchDeletetAdminEvent($tableMap,$id);
        });
        $events->listen('vanhenry.manager.insert.success', function ($table, $data, $id)
        {
            $tableMap = $table;
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                $tableMap = $table->table_map;
            }
            \VideoSetting::catchInsertAdminEvent($tableMap,$data,$id);
        });
        $events->listen('vanhenry.manager.update_normal.success', function ($table, $data, $id, $oldData)
        {
            $tableMap = $table;
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                $tableMap = $table->table_map;
            }
            $dataNew = \DB::table($tableMap)->find($id);
            \VideoSetting::catchUpdateAdminEvent($tableMap,$oldData,$dataNew);
        });
        $events->listen('vanhenry.manager.media.delete.success', function ($fname, $id)
        {
            $itemMedia = Media::find($id);
            \VideoSetting::deleteTvsSecret($itemMedia);;
        });
        $events->listen('vanhenry.manager.media.insert.success', function ($name, $id)
        {
            $itemMedia = Media::find($id);
            \VideoSetting::createTvsSecret($itemMedia);
        });
    }
}