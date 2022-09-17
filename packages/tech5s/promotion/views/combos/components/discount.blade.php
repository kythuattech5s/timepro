<div class="combo-group__form align-items-baseline">
    <label>Loại combo</label>
    <div class="combo-group-options">
        <div class="combo-group__item">
            <div class="combo-group-type" m-checked="Vui lòng chọn loại giảm giá">
                <input type="radio" name="type" rules="required"
                    value="{{ ComboHelper::TYPE_PERCENT }}" {{ $currentItem->type == ComboHelper::TYPE_PERCENT ? 'checked' : ''}}>
                <label for="combo-type-percent">Giảm giá theo %</label>
            </div>
            <div class="group-form" style="{{ $currentItem->type == ComboHelper::TYPE_PERCENT ? '' : 'display:none'}}">
                <span>Mua</span>
                <input type="text" name="qty"  value="{-currentItem.qty-}" rules="required" {{ $currentItem->type == ComboHelper::TYPE_PERCENT ? '' : 'disabled'}}>
                <span>sản phẩm để được giảm</span>
                <div class="group-small">
                    <input type="text" name="discount" value="{{ $currentItem->type == ComboHelper::TYPE_PERCENT ? $currentItem->discount : ''}}" rules="required" m-required="Vui lòng nhập % giảm giá" percent {{ $currentItem->type == ComboHelper::TYPE_PERCENT ? '' : 'disabled'}}>
                    <span>% Giảm</span>
                </div>
            </div>
            @if($currentItem->type == ComboHelper::TYPE_PERCENT)
                <p class="note-type">Giá cuối cùng = Giá hiện tại - {{$currentItem->discount}} %</p>
            @endif
        </div>
        <div class="combo-group__item">
            <div class="combo-group-type" m-checked="Vui lòng chọn loại giảm giá">
                <input type="radio" name="type"
                    value="{{ ComboHelper::TYPE_MONEY }}" rules="required" {{ $currentItem->type == ComboHelper::TYPE_MONEY ? 'checked' : ''}}>
                <label for="combo-type-percent">Giảm giá theo số tiền</label>
            </div>
            <div class="group-form" style="{{ $currentItem->type == ComboHelper::TYPE_MONEY ? '' : 'display:none'}}">
                <span>Mua</span>
                <input type="text" name="qty" value="{-currentItem.qty-}" rules="required" {{ $currentItem->type == ComboHelper::TYPE_MONEY ? '' : 'disabled'}}>
                <span>sản phẩm để được giảm</span>
                <div class="group-small">
                    <input type="text" name="discount" value="{{ $currentItem->type == ComboHelper::TYPE_MONEY ? $currentItem->discount : ''}}" m-required="Vui lòng nhập mức giảm lớn hơn 0" rules="required" {{ $currentItem->type == ComboHelper::TYPE_MONEY ? '' : 'disabled'}}>
                    <span>₫</span>
                </div>
            </div>
            @if($currentItem->type == ComboHelper::TYPE_MONEY)
                <p class="note-type">Giá cuối cùng = Giá hiện tại - ₫{{number_format($currentItem->discount,0,',','.')}}</p>
            @endif
        </div>
        <div class="combo-group__item">
            <div class="combo-group-type" m-checked="Vui lòng chọn loại giảm giá">
                <input type="radio" name="type" value="{{ ComboHelper::TYPE_SPECIAL }}" rules="required" {{ $currentItem->type == ComboHelper::TYPE_SPECIAL ? 'checked' : ''}}>
                <label for="combo-type-percent">Giảm giá đặc biệt</label>
            </div>
            <div class="group-form" style="{{ $currentItem->type == ComboHelper::TYPE_SPECIAL ? '' : 'display:none'}}">
                <span>Mua</span>
                <input type="text" name="qty" value="{-currentItem.qty-}" rules="required" {{ $currentItem->type == ComboHelper::TYPE_SPECIAL ? '' : 'disabled'}}>
                <span>sản phẩm chỉ với</span>
                <div class="group-small">
                    <input type="text" name="discount" value="{{ $currentItem->type == ComboHelper::TYPE_SPECIAL ? $currentItem->discount : ''}}" m-required="Vui lòng nhập mức giảm lớn hơn 0" rules="required" {{ $currentItem->type == ComboHelper::TYPE_SPECIAL ? '' : 'disabled' }}>
                    <span>₫</span>

                </div>
            </div>
            @if($currentItem->type == ComboHelper::TYPE_SPECIAL)
                <p class="note-type">Giá cuối cùng = ₫{{number_format($currentItem->discount,0,',','.')}}</p>
            @endif
        </div>
    </div>
</div>
