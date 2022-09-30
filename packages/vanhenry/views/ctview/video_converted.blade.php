<td data-title="{{$show->note}}" style="text-align:left">
    <?php $videoConvertStatus = FCHelper::ep($dataItem,$show->name); ?>
    @if($videoConvertStatus ==  \modulevideosecurity\managevideo\Models\TvsSecret::CONVERTED_WAIT)
        <p style="color:#6c757d;">Video Đang Chờ Mã Hóa</p>
    @elseif($videoConvertStatus ==  \modulevideosecurity\managevideo\Models\TvsSecret::CONVERTED_START)
        <p style="color:#ffc107;">Video Đang Được Mã Hóa</p>
    @elseif($videoConvertStatus == \modulevideosecurity\managevideo\Models\TvsSecret::CONVERTED_COMPLETE)
        <p style="color:#28a745;">Video Đã Hoàn Thành Mã Hóa</p>
    @else
        <p style="color:#dc3545;">Video Mã Hóa Lỗi</p>
        <a href="{{url('esystem/reset-status-convert-video/'.FCHelper::ep($dataItem,'id'))}}" style="padding:10px;background:#343a40;border-radius:5px;display:inline-block;color:#fff;">Thử Mã Hóa Lại</a>
    @endif
</td>