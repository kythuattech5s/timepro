<h4>Sản phẩm mua kèm</h4>
<p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi họ mua bất
    kỳ sản phẩm chính nào.
</p>
<div class="header d-flex justify-content-between mb-3">
    <p></p>
    @if (!isset($lock) || !$lock)
        <button type="button" class="btn bg-orange-300" data-toggle="modal" data-target="#modalProduct"
            data-type="{{$promotion}}" data-action="{{$action}}" data-type-product="{{$type}}">
            Thêm sản phẩm
        </button>
    @endif
</div>
<div class="item-action d-flex justify-content-between">
    <div>
        <p>Chỉnh sửa hàng loạt</p>
        <span>Đã chọn <span class="count-product-chooses">0</span> sản phẩm</span>
    </div>
    <div class="discount">
        <p>Khuyến mãi</p>
        <div class="form-group">
            <input type="text" name="discount" placeholder="">
            <span>%GIẢM</span>
        </div>
    </div>
    <div>
        <p>Giới hạn đặt hàng</p>
        <div class="form-group">
            <input type="text" name="limit_discount" placeholder="">
        </div>
    </div>
    <div class="button-action">
        <button type="button" class="update-deal btn btn-sm bg-blue-400 text-white" data-type-product="{{$type}}">Cập nhật hàng loạt</button>
        <button class="on btn btn-sm bg-green-400 text-white" data-type-product="{{$type}}" disabled c-disabled>Bật</button>
        <button class="off btn btn-sm bg-red-400 text-white" data-type-product="{{$type}}" disabled c-disabled>Tắt</button>
        <button type="button" class="remove btn btn-sm bg-orange-400 text-white" data-type-product="{{$type}}" disabled c-disabled><i class="fa fa-trash-o" aria-hidden="true"></i></button>
    </div>
</div>
<div class="table-item">
    <div class="head-product-deal">
        <label for="product-multiple" class="d-block">
            <input type="checkbox" id="product-multiple" c-multiple>
            <textarea name="product_chooses" cols="30" rows="10" style="display: none" c-data></textarea>
            <span></span>
        </label>
        <div class="name-product">
            Sản phẩm
        </div>
        <div class="price-group">
            Giá gốc
        </div>
        <div class="price-group">
            Giá đã giảm
        </div>
        <div class="warehouse">
            Kho hàng
        </div>
        <div class="limit-order">
            Giới hạn đặt hàng
        </div>
        <div class="order-item">
            Sắp xếp
        </div>
        <div class="action-active">
            Bật / Tắt
        </div>
        <div class="action-box">
            Hành Động
        </div>
    </div>
    <div class="item-product-deal">
        @foreach ($products as $product)
            @php
                $limit = '';
                if($product->flash_sale->count() == 0 && isset($currentItem)){
                    $flash_sale = $product->variants->first() !== null ? $product->variants->first()->flash_sale->first() : null;
                    $limit = $flash_sale !== null ? $flash_sale->pivot->limit : $limit;
                }elseif(isset($currentItem)){
                    $flash_sale = $product->flash_sale()->where('flash_sale_id',$currentItem->id)->first();
                    $limit = $flash_sale !== null ? $flash_sale->pivot->limit : $limit;
                }
            @endphp
            <div class="item" c-check-item data-id="{-product.id-}" draggable>
                <div class="header">
                    <label for="product-{-product.id-}" style="display:block">
                        <input type="checkbox" value="{-product.id-}" id="product-{-product.id-}" c-parent-single>
                        <span></span>
                    </label>
                    <div class="name-product">
                        <img src="{%IMGV2.product.img.390x0%}" alt="{%AIMGV2.product.img.alt%}"
                            title="{%AIMGV2.product.img.title%}">
                        <a href="{-product.slug-}" target="_blank">{-product.name-}</a>
                    </div>
                    <div>
                    </div>
                    <div class="text-right pe-4">
                        <button type="button" class="btn bg-red-400 text-white remove-item" data-type-product="sub" data-action="{{$action}}">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="body">
                    @if($product->variants()->count() > 0)
                        @foreach($product->variants as $item)
                            @include('tp::deals.components.itemChild')
                        @endforeach
                    @else
                        @include('tp::deals.components.itemChild',['item' => $product,'noProperty' => true])
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex mt-4 justify-content-end">
        <button type="button" class="btn bg-green-400 text-white save-product-sub" data-type="{{$promotion}}" data-type-product="{{$type}}" data-action="{{$action}}">Lưu</button>
    </div>
</div>
