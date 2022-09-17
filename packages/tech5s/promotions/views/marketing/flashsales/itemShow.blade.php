<div class="header d-flex justify-content-between">
    <p></p>
    @if (!isset($lock) || !$lock)
        <button type="button" class="btn bg-orange-300" data-toggle="modal" data-target="#modalProduct"
            data-type="flash_sales" data-action="{{$action}}">
            Thêm sản phẩm
        </button>
    @else
        <button style="display: none;" data-type="flash_sales" >
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
        <p>SL sản phẩm khuyến mãi</p>
        <div class="form-group">
            <input type="text" name="qty_discount" placeholder="">
        </div>
    </div>
    <div>
        <p>Giới hạn đặt hàng</p>
        <div class="form-group">
            <input type="text" name="limit_discount" placeholder="">
        </div>
    </div>
    <div class="button-action">
        <button type="button" class="update-flash-sale btn btn-sm bg-blue-400 text-white">Cập nhật hàng loạt</button>
        <button class="on btn btn-sm bg-green-400 text-white">Bật</button>
        <button class="off btn btn-sm bg-red-400 text-white">Tắt</button>
        <button class="remove btn btn-sm btn-orange" disabled c-disabled><i class="fa fa-trash-o" aria-hidden="true"></i></button>
    </div>
</div>
<div class="table-item">
    <div class="head-product-flash-sale">
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
            Giá đã giảm - Khuyến mãi
        </div>
        <div class="quantity-product">
            SL sản phẩm khuyến mãi
        </div>
        <div class="warehouse">
            Kho hàng
        </div>
        <div class="limit">
            Giới hạn đặt hàng
        </div>
        <div class="active-action">
            Bật / Tắt
        </div>
        <div class="action-box">
            Hành Động
        </div>
    </div>
    <div class="item-product-flash-sale">
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
            <div class="item" c-check-item data-id="{-product.id-}">
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
                    <div class="price-group"></div>
                    <div class="price-group"></div>
                    <div class="quantity-product"></div>
                    <div class="warehouse"></div>
                    <div class="limit">
                        <input type="text" name="limit" value="{{$limit}}" placeholder="Giới hạn đặt hàng">
                    </div>
                    <div class="active-action">
                    </div>
                    <div class="action-box">
                        <button type="" class="btn btn-danger delete-item">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="body">
                    @if($product->variants->count() > 0)
                        @foreach($product->variants as $item)
                            @include('tech5spromotion::marketing.flashsales.itemChild')
                        @endforeach
                    @else
                        @include('tech5spromotion::marketing.flashsales.itemChild',['item' => $product,'noProperty' => true])
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
