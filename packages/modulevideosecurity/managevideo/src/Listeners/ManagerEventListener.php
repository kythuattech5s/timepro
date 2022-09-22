<?php 
namespace modulevideosecurity\managevideo\Listeners;
use \vanhenry\manager\model\Media;
class ManagerEventListener
{
    public function subscribe($events)
    {
        $events->listen('vanhenry.manager.delete.success', function ($table, $id)
        {
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                $id = is_array($id) ? implode(",", $id) : $id;
                \VideoSetting::catchDeletetAdminEvent($table->table_map,$id);
            }
        });
        $events->listen('vanhenry.manager.insert.success', function ($table, $data, $injects, $id)
        {
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                \VideoSetting::catchInsertAdminEvent($table->table_map,$data,$id);
            }
        });
        $events->listen('vanhenry.manager.update_normal.success', function ($table, $data, $injects, $id)
        {
            if ($table instanceof \vanhenry\manager\model\VTable)
            {
                $dataNew = \DB::table($table->table_map)->find($id);
                \VideoSetting::catchUpdateAdminEvent($table->table_map,$data,$dataNew);
            }
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