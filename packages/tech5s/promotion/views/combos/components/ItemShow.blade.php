@if ($products->count() > 0)
    <div class="header d-flex justify-content-between mb-3">
        <p></p>
        @if (!isset($lock) || !$lock)
            <button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct"
                data-action="{{ $action }}" data-type="{{ $promotion }}">
                Thêm sản phẩm
            </button>
        @endif
    </div>
    <div class="action-item d-flex justify-content-between flex-wrap">
        <div>
            <p class="title">Thiết lập nhóm sản phẩm</p>
            <p>Đã chọn <span class="count-product-chooses">0</span> sản phẩm</p>
        </div>
        <div class="action-button">
            <button type="button" class="btn btn-sm bg-blue-400 text-white on" disabled c-disabled>Kích hoạt hàng loạt</button>
            <button type="button" class="btn btn-sm bg-orange-300 off" disabled c-disabled>Tắt hàng loạt</button>
            <button type="button" class="btn btn-sm bg-red-400 text-white remove" disabled c-disabled>Xóa hàng loạt</button>
        </div>
    </div>
    <table class="table center table-deal-soc">
        <thead>
            <tr>
                <th>
                    <label for="product-multiple" class="d-block">
                        <input type="checkbox" id="product-multiple" c-multiple>
                        <span></span>
                        <textarea name="product_chooses" cols="30" rows="10" style="display: none" c-data></textarea>
                    </label>
                </th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Kho hàng</th>
                <th>Kích hoạt</th>
                @if (!isset($lock) || !$lock)
                    <th>Hành động</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($products as $key => $product)
                <tr data-id="{-product.id-}">
                    <td>
                        <label for="product-{-product.id-}" style="display:block">
                            <input type="checkbox" value="{-product.id-}" name="id" id="product-{-product.id-}" c-single>
                            <span></span>
                        </label>
                    </td>
                    <td class="text-left flex justify-start space-x-2">
                        <img src="{%IMGV2.product.img.-1%}" alt="{%AIMGV2.product.img.alt%}" title="{%AIMGV2.product.img.title%}">
                        <a href="{-product.slug-}" target="_blank">
                            {-product.name-}
                        </a>
                    </td>
                    @php
                        $listPrice = $product->getPrice();
                    @endphp
                    <td data-price="{{$listPrice->min()}}">
                        @if ($listPrice->count() > 1)
                            {{ Currency::showMoney($listPrice->min()) }}
                        @else
                            {{ Currency::showMoney($listPrice->first()) }}
                        @endif
                    </td>
                    <th>{{$product->variants->sum('remain')}}</th>
                    <td>
                        @php
                            $checked = false;
                            if(isset($product_checked)){
                                $checked = $product_checked->first(function($product_id) use($product){{
                                    return $product_id == $product->id;
                                }}) !== null ? true : false;
                            }
                        @endphp
                        <label class="switch">
                            <input type="checkbox" name="act" value="{{ $checked ? 1 : 0 }}"
                                {{ $checked ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </td>
                    @if (!isset($lock) || !$lock)
                        <td>
                            <div class="action">
                                <button type="button" class="btn btn-sm bg-red-400 text-white remove-item" title="Xóa"><i class="fa fa-trash-o"
                                        aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="100%">Không có kết quả phù hợp.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@else
    <button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct"
        data-action="{{ $action }}" data-type="{{ $promotion }}">
        Thêm sản phẩm
    </button>
@endif
