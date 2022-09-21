<link rel="stylesheet" href="{'admin/promotion/assets/css/voucher.css'}">
<div class="modal fade" id="voucher--box" tabindex="-1" aria-labelledby="voucher--boxLabel" aria-hidden="true" data-action="{{$typeAction ?? 'cart'}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucher--boxLabel">Chọn hoặc nhập mã giảm giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="voucher--box__form">
                    <span>Mã Voucher</span>
                    <input type="text" name="voucher_code" value="{{isset($voucher) && $voucher->voucher !== null ? $voucher->voucher->code : ''}}" {{isset($voucher) && $voucher->voucher !== null ? 'disabled' : ''}}>
                    <button type="button" class="btn btn-sm btn-red__all">{{isset($voucher) && $voucher->voucher !== null ? 'Hủy áp dụng' : 'Áp dụng'}}</button>
                </div>
                <div class="voucher--box__list">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-red__all apply">Xác nhận</button>
            </div>
        </div>
    </div>
</div>
