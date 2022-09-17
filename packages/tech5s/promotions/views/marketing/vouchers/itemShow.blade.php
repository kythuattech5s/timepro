@if ($products->count() > 0)
<div class="header d-flex justify-content-between mb-3">
    <p>Đã chọn <span class="count-product-chooses">{{ $products->count() }}</span> sản phẩm</p>
    @if (!isset($lock) || !$lock)
    <button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="vouchers">
        Thêm sản phẩm
    </button>
    @endif
</div>
<table class="table">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            @if (!isset($lock) || !$lock)
            <th>Hành động</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($products as $key => $product)
        <tr data-id="{-product.id-}">
            <td class="text-left">
                <img src="{%IMGV2.product.img.-1%}" alt="{%AIMGV2.product.img.alt%}"
                     title="{%AIMGV2.product.img.title%}">
                <a href="{-product.slug-}" target="_blank">
                    {-product.name-}
                </a>
            </td>
            @php
            $listPrice = $product->getPrice();
            @endphp
            <td>
                @if ($listPrice->count() > 1)
                {{ Currency::showMoney($listPrice->min()) }}
                <p>~</p>
                {{ Currency::showMoney($listPrice->max()) }}
                @else
                {{ Currency::showMoney($listPrice->first()) }}
                @endif
            </td>
            @if (!isset($lock) || !$lock)
            <td>
                <div class="action">
                    <button type="button" class="btn btn-sm btn-danger" title="Xóa"><i class="fa fa-trash-o"
                           aria-hidden="true"></i>
                    </button>
                </div>
            </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="100%">Không có kết quả hợp lệ!</td>
        </tr>
        @endforelse
    </tbody>
</table>
@else
<button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="vouchers">
    Thêm sản phẩm
</button>
@endif