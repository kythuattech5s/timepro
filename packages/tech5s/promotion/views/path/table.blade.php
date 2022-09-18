<table class="tableFixHead table border">
    <thead>
        <tr>
            <th>
                <label for="checkAll">
                    <input type="checkbox" id="checkAll" class="d-none" c-multiple>
                    <span></span>
                    <textarea class="d-none" id="" cols="30" rows="10" c-data>
                        @if(isset($listChecked))
                            {{json_encode($listChecked,JSON_UNESCAPED_UNICODE)}}
                        @endif
                    </textarea>
                </label>
            </th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
        </tr>
    </thead>
    @include('sp::path.itemList')
</table>