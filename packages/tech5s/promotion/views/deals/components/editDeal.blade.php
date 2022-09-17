<h4>Thông tin cơ bản</h4>
<div class="deal-group__form">
    <input type="hidden" name="id" value="{-currentItem.id-}">
    <label>Loại Deal</label>
    <div class="deal-type">
        <div class="deal-type__item position-relative">
            <input class="form-control" type="radio" id="type_code_shop" name="type"
                   value="{{ DealHelper::TYPE_DEAL }}" {{ $currentItem->type == DealHelper::TYPE_DEAL ? 'checked' : '' }}>
            <label for="type_code_shop" class="flex items-center">
                <img src="{{ asset('admin/promotion/assets/images/shops.png') }}" class="mr-2" alt="Shop">
                Mua Kèm Deal Sốc
            </label>
        </div>
        <div class="deal-type__item position-relative">
            <input class="form-control" type="radio" id=type_code_product name="type"
                   value="{{ DealHelper::TYPE_GIFT }}" {{ $currentItem->type == DealHelper::TYPE_GIFT ? 'checked' : '' }}>
            <label for="type_code_product" class="flex items-center">
                <img src="{{ asset('admin/promotion/assets/images/online-shopping.png') }}" class="mr-2" alt="Shop">
                Mua Để Nhận Quà
            </label>
        </div>
    </div>
</div>
<div class="deal-group__form">
    <label for="deal_name">Tên chương trình</label>
    <input class="form-control" type="text" rules="required" id="deal_name" name="name" value="{{ $action == 'copy' ? '' : $currentItem->name }}" placeholder="Tên chương trình">
</div>
<div class="deal-group__form">
    <label>Thời gian bắt đầu/ kết thúc</label>
    <div class="deal-datetime">
        <input class="form-control" type="datetime-local" name="start_at" rules="required"
               m-required="Vui lòng chọn thời gian bắt đầu" value="{{ date('Y-m-d\TH:i', strtotime($action == 'copy' ? time() + 60 * 10 : $currentItem->start_at)) }}">
        <input class="form-control" type="datetime-local" name="expired_at"
               value="{{ date('Y-m-d\TH:i', strtotime($action == 'copy' ? time() + 60 * 10 + 60 * 60 : $currentItem->expired_at)) }}" rules="required"
               m-required="Vui lòng chọn thời gian kết thúc">
    </div>
</div>
<div class="deal-group__form align-items-baseline" data-type="{{ DealHelper::TYPE_DEAL }}" style="{{ $currentItem->type == DealHelper::TYPE_DEAL ? '' : 'display:none' }}">
    <label for="deal_name">Giới hạn mua kèm sản phẩm</label>
    <div class="flex-fill">
        <input class="form-control" type="text" rules="required" id="limit" name="limit"
               placeholder="Số lượng tối đa 100" value="{-currentItem.limit-}" {{ $currentItem->type == DealHelper::TYPE_DEAL ? '' : 'disabled' }}>
        <p class="mt-2">Số lượng tối đa sản phẩm deal sốc mỗi khách được phép mua kèm cho mỗi
            đơn
            hàng.
        </p>
    </div>
</div>
<div class="deal-group__form" data-type="{{ DealHelper::TYPE_GIFT }}" style="{{ $currentItem->type == DealHelper::TYPE_GIFT ? '' : 'display:none' }}">
    <label for="deal_name">Điều kiện nhận quà</label>
    <div class="form-gift d-flex align-items-center">
        <p>Mua</p>
        <div class="group-input">
            <span>₫</span>
            <input type="text" name="price" value="{{ $currentItem->price > 0 ? $currentItem->price : '' }}" rules="required" {{ $currentItem->type == DealHelper::TYPE_GIFT ? '' : 'disabled' }}>
        </div>
        <p>để nhận</p>
        <input type="text" name="qty" rules="required" value="{-currentItem.qty-}" placeholder="Nhập số lượng ít hơn 50" {{ $currentItem->type == DealHelper::TYPE_GIFT ? '' : 'disabled' }}>
        <p>quà tặng</p>
    </div>
</div>
<div class="deal-group__form align-items-baseline">
    <label for="shop_id">Điều kiện nhận quà</label>
    <div class="flex-1">
        <input type="text" placeholder="Nhập tên shop" class="search-shop form-control my-2">
        <select name="shop_id" id="shop_id" class="form-control">
            <option value="{-shop.id-}">{-shop.name-}</option>
        </select>
    </div>
</div>
<div class="deal-group__form justify-content-end">
    <button type="button" class="btn {{ $action == 'copy' ? 'save-deal' : 'save-edit-deal' }} bg-green-400 text-white" data-action="{{ $action }}">Lưu</button>
</div>
