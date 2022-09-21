<td>
    @php
        $start_at = new DateTime($dataItem->start_at);
        $expired_at = new DateTime($dataItem->expired_at);
        $now = new DateTime();
        $string = '';
        if($now > $expired_at){
            $string = 'Đã kết thúc';
            $background = '#e35d6a';
            $color = 'white';
        }elseif($start_at < $now && $expired_at > $now ){
            $string = 'Đang diễn ra';
            $background = '#00af4c';
            $color = 'white';
        }else{
            $string = 'Sắp diễn ra';
            $background = '#ffc142'; 
            $color = 'white';
        }
    @endphp
    <p style="padding:4px 10px;border-radius:5px;background:{{$background}}; color:{{$color}}">{{$string}}</p>
</td>