<div class="d-flex justify-content-between">
    <div>
        <h4>Sản phẩm chính</h4>
        <p>Số lượng tối đa mỗi khách được mua là 100 sản phẩm chính trong cùng 1 chương
            trình Mua Kèm Deal Sốc
        </p>
    </div>
    <button class="btn btn-link edit-product-main @if(isset($noEdit) && $noEdit) no-edit @endif" data-id="{-currentItem.id-}" data-type-product="main" data-action="{{$action}}" data-type="{{$promotion}}">
        <i class="fa fa-pencil" aria-hidden="true"></i>
        Thay đổi
    </button>
</div>
<table class="table center table-deal-soc">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Kho hàng</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $key => $product)
            <tr>
                <td class="text-left flex justify-start space-x-2">
                    <img src="{%IMGV2.product.img.-1%}" alt="{%AIMGV2.product.img.alt%}"
                     title="{%AIMGV2.product.img.title%}">
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
                <td>{{$product->variants->sum('qty')}}</td>
                <td>
                    @php
                        $checked = false;
                        if(isset($product_checked)){
                            $checked = $product_checked->first(function($product_id) use($product){{
                                return (int) $product_id == (int) $product->id;
                            }}) !== null ? true : false;
                        }
                    @endphp
                    {{$checked ? 'Bật' : 'Tắt'}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%">Không có kết quả hợp lệ!</td>
            </tr>
        @endforelse
    </tbody>
</table>
