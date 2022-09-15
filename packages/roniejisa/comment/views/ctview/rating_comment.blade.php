<?php
    $defaultData = 	json_decode(FCHelper::ep($show,"default_data"), true);
    $detailData = DB::table($defaultData['table'])->select(['id',$defaultData['field']])->where($defaultData['field_relationship'],$dataItem->id)->first();
    $field = $defaultData['field'];
?>
<td>
    <span class="rating">
        <i class="fa fa-star-o"></i>
        <i class="fa fa-star-o"></i>
        <i class="fa fa-star-o"></i>
        <i class="fa fa-star-o"></i>
        <i class="fa fa-star-o"></i>
        <div class="rating--active" style="width:{{($detailData->$field ?? 0) * 20}}%">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
        </div>
    </span>
</td>
