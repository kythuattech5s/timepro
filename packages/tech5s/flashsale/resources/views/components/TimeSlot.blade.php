@php
    $start_at = $flash_sale->start_at instanceof DateTime ? $flash_sale->start_at : new DateTime($flash_sale->start_at);
    $expired_at = $flash_sale->start_at instanceof DateTime ? $flash_sale->expired_at : new DateTime($flash_sale->expired_at);
@endphp
<span class="flash-sale-editable tooltipx cursor-pointer bg-green-600 border rounded-md p-2 text-white font-bold">
    {{$start_at->format('H:i d/m/Y')}} - {{$expired_at->format('H:i d/m/Y')}}
    <span class="tooltiptext">Click 2 lần để chỉnh sửa</span>
</span>