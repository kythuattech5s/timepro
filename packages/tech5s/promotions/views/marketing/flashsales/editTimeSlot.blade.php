@php
    $start_at = $flash_sale->start_at instanceof DateTime ? $flash_sale->start_at : new DateTime($flash_sale->start_at);
    $expired_at = $flash_sale->start_at instanceof DateTime ? $flash_sale->expired_at : new DateTime($flash_sale->expired_at);
@endphp
<input class="form-control" type="datetime-local" name="start_at" rules="required"
    m-required="Vui lòng chọn thời gian bắt đầu" value="{{ date('Y-m-d\TH:i', strtotime($start_at->format('Y-m-d H:i:s'))) }}">
<input class="form-control" type="datetime-local" name="expired_at"
    value="{{ date('Y-m-d\TH:i', strtotime($expired_at->format('Y-m-d H:i:s'))) }}" rules="required"
    m-required="Vui lòng chọn thời gian kết thúc">
<button class="btn btn-sm bg-green-400 text-white saveTimeSlot" type="button">Lưu</button>
