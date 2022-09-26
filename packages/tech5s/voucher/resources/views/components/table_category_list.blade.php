<table class="table">
    <thead>
        <tr>
            <th>
                <label for="check-all-category">
                    <input type="checkbox" id="check-all-category" class="d-none" c-multiple>
                    <span></span>
                </label>
                <textarea name="list_category" class="d-none" id="" cols="30" rows="10" c-data>{{ json_encode($listProducts->toArray(), JSON_UNESCAPED_UNICODE) }}</textarea>
            </th>
            <th>Tên</th>
            {{-- <th>Số lượng {{ config('tpvc_setting.table_name') }}</th> --}}
        </tr>
    </thead>
    <tbody>
        @forelse($listItems as $item)
            @php
                $checked = isset($listProducts) && $listProducts->contains(fn($product) => isset($product['id']) && $product['id'] == $item->id);
            @endphp
            <tr>
                <td>
                    <label for="category-{-item.id-}">
                        <input type="checkbox" @if ($checked) checked @endif class="d-none" data-checked="id" id="category-{-item.id-}" value="{-item.id-}" data-checked-main c-single>
                        <span></span>
                    </label>
                </td>
                <td>{-item.name-}</td>
                {{-- <td></td> --}}
            </tr>
        @empty
            <tr>
                <td colspan="100%">Không tìm thấy danh mục {{ config('tpvc_setting.table_name') }} nào!</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $listItems->withQueryString()->links('vh::base.pagination', ['attribute' => 'data-promotion=vouchers data-page', 'attributeAjax' => 'pagination-category-list']) }}
