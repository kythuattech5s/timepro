<?php
    $img = 'admin/images/noimage.png';
    $value = FCHelper::ep($dataItem, $show->name);
    $tmp = json_decode($value, true);
    $img = isset($tmp) && is_array($tmp) && array_key_exists('path', $tmp) ? $tmp['path'] . $tmp['file_name'] : $img;
    if ($img == 'admin/images/noimage.png') {
        $img = FCHelper::eimg2($dataItem, $show->name);
    }
?>

<td data-title="<?php echo e($show->note); ?>">
    <img src="<?php echo e($img); ?>" style="max-width: 70px;max-height: 70px;margin: 2px auto;" class="img-responsive">
</td>
<?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctview/imagev2.blade.php ENDPATH**/ ?>