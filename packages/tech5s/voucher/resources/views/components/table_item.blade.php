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
        @forelse($listItems as $key => $item)
            <tr data-id="{-item.id-}">
                <td data-label="Sản phẩm" class="align-items-center flex justify-start space-x-2 text-left">
                    <img src="{%IMGV2.item.img.-1%}" alt="{%AIMGV2.item.img.alt%}"
                         title="{%AIMGV2.item.img.title%}">
                    <a href="{-item.slug-}" target="_blank">
                        {-item.name-}
                    </a>
                </td>
                {{-- @php
                    $listPrice = collect($item->getFirstPrice());
                @endphp --}}
                <td data-label="Giá">
                    {{-- @if ($listPrice->count() > 1)
                        {{ Currency::showMoney($listPrice->min()) }}
                        <p>~</p>
                        {{ Currency::showMoney($listPrice->max()) }}
                    @else
                        {{ Currency::showMoney($listPrice->first()) }}
                    @endif --}}
                </td>
                @if (!isset($lock) || !$lock)
                    <td data-label="Thao tác">
                        <div class="action">
                            <button type="button" class="btn btn-sm bg-red-400 text-white" title="Xóa"><i class="fa fa-trash-o" aria-hidden="true"></i>
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
{{ $listItems->withQueryString()->links('vh::base.pagination', ['attributeAjax' => 'pagination-voucher-list', 'attribute' => 'data-promotion=vouchers data-page']) }}
