<thead>
    <tr>
        <th>
            <label for="product-multiple-modal" class="d-block">
                <input type="checkbox" id="product-multiple-modal" c-multiple>
                <span></span>
            </label>
            <textarea style="display:none" name="product_choose" id="" cols="30" rows="10" c-data>{{ json_encode(json_decode($product_chooses,true),JSON_UNESCAPED_UNICODE) }}</textarea>
        </th>
        <th>Sản phẩm</th>
        <th>Giá</th>
    </tr>
</thead>
<tbody>
    @include('tp::components.all_product')
</tbody>
@if($products->count() > 0 && $products->lastPage() > 1)
<tfoot>
    <tr>
        <td colspan="100%" class="justify-content-end">
            {{ $products->withQueryString()->links('vh::base.pagination',['attributeAjax' => 'paginate-modal-product']) }}
        </td>
    </tr>
</tfoot>
@endif
