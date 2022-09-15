@php
    $name = FCHelper::er($table,'name');
    $value = "";
    if($actionType=='edit'||$actionType=='copy'){
        $value = FCHelper::er($dataItem,$name);
    }
    $listItemPackage = Support::extractJson($value,false);
@endphp
<style>
    .table-manage-time-package{
        width: 100%;
        border: solid 1px #aaa!important;
        border-radius: 0!important;
    }
    .table-manage-time-package tbody tr{
        border-top: solid 1px #aaa!important;
    }
    .table-manage-time-package th:not(:last-child),.table-manage-time-package td:not(:last-child){
        border-right: solid 1px #aaa;
    }
    .table-manage-time-package th{
        color: #808080;
        background: #ebebeb;
        font-size: 16px;
        font-weight: bold;
        padding: 5px 6px;
    }
    .table-manage-time-package td{
        padding: 6px;
    }
    .btn-add-item-time-package,.btn-delete-item-time-package{
        font-size: 16px;
    }
    .table-manage-time-package input,.table-manage-time-package textarea{
        border: solid 1px #aaa;
    }
    .table-manage-time-package .description{
        width: 180px!important;
    }
    .table-manage-time-package .number_day{
        width: 100px;
    }
</style>
<textarea class="hidden" name="{{$name}}"><?php echo $value;?></textarea>
<div class="manage-time-package table-responsive">
    <table class="table-manage-time-package">
        <thead>
            <tr>
                <th>Tên gói</th>
                <th>Mô tả (nếu có)</th>
                <th>Thời gian</th>
                <th>Giá</th>
                <th>Giá cũ</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listItemPackage as $itemPackage)
                <tr class="item-manage-time-package">
                    <input type="hidden" class="id_item" value="{{$itemPackage->id_item ?? 0}}">
                    <td>
                        <input type="text" class="name" placeholder="Tên gói" value="{{$itemPackage->name ?? ''}}">
                    </td>
                    <td>
                        <textarea rows="2" class="description py-1 px-2">{{$itemPackage->description ?? ''}}</textarea>
                    </td>
                    <td>
                        <div class="d-flex align-items-center mb-2">
                            <span>Nhập số ngày:</span>
                            <input type="number" class="number_day ms-2" placeholder="Số ngày" value="{{$itemPackage->number_day ?? ''}}">
                        </div>
                        <div class="d-flex align-items-center">
                            <span>Hoặc vĩnh viễn:</span>
                            <input type="checkbox" class="is_forever mt-0 ms-2" style="width: 20px;height: 20px" {{isset($itemPackage->is_forever) && $itemPackage->is_forever == 1 ? 'checked':''}}>
                        </div>
                    </td>
                    <td>
                        <input type="number" placeholder="Giá" class="price" value="{{$itemPackage->price ?? 0}}">
                    </td>
                    <td>
                        <input type="number" placeholder="Giá cũ" class="price_old" value="{{$itemPackage->price_old ?? 0}}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger py-1 btn-delete-item-time-package">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-center mt-3">
        <button type="button" class="btn btn-info px-5 btn-add-item-time-package">Thêm gói</button>
    </div>
</div>
<script>
    var MANAGE_ITEM_PACKAGE = (function(){
        var baseItemTimePackage = `
            <tr class="item-manage-time-package">
                <input type="hidden" class="id_item" value="0">
                <td>
                    <input type="text" class="name" placeholder="Tên gói">
                </td>
                <td>
                    <textarea rows="2" class="description py-1 px-2"></textarea>
                </td>
                <td>
                    <div class="d-flex align-items-center mb-2">
                        <span>Nhập số ngày:</span>
                        <input type="number" class="number_day ms-2" placeholder="Số ngày">
                    </div>
                    <div class="d-flex align-items-center">
                        <span>Hoặc vĩnh viễn:</span>
                        <input type="checkbox" class="is_forever mt-0 ms-2" style="width: 20px;height: 20px">
                    </div>
                </td>
                <td>
                    <input type="number" placeholder="Giá" class="price">
                </td>
                <td>
                    <input type="number" placeholder="Giá cũ" class="price_old">
                </td>
                <td>
                    <button type="button" class="btn btn-danger py-1 btn-delete-item-time-package">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
        `;
        var buildData = function(){
            var listItem = $('.item-manage-time-package');
            var data = {};
            listItem.each(function (idx, element) {
                var currentItem = $(element);
                var itemInfo = {};
                itemInfo.id_item = currentItem.find('input.id_item').val();
                itemInfo.name = currentItem.find('input.name').val();
                itemInfo.description = currentItem.find('textarea.description').val();
                itemInfo.number_day = currentItem.find('input.number_day').val();
                itemInfo.is_forever = currentItem.find('input.is_forever').is(':checked') ? 1:0;
                itemInfo.price = currentItem.find('input.price').val();
                itemInfo.price_old = currentItem.find('input.price_old').val();
                data[idx] = itemInfo;
            });
            $('textarea[name={{$name}}]').val(JSON.stringify(data));
        }
        var initBtnAddItem = function(){
            $('.btn-add-item-time-package').click(function(){
                $('.table-manage-time-package tbody').append(baseItemTimePackage);
                buildData();
            });
        }
        var initBtnDeleteItem = function(){
            $(document).on('click','.btn-delete-item-time-package',function(){
                $(this).closest('.item-manage-time-package').remove();
                buildData();
            });
        }
        var initInputChange = function(){
            $(document).on('input','.item-manage-time-package input,.item-manage-time-package textarea',function(){
                buildData();
            });
        }
        return {
            _(){
                initBtnAddItem();
                initBtnDeleteItem();
                initInputChange();
		    }
	    };
    })();
    $(document).ready(function () {
        MANAGE_ITEM_PACKAGE._();
    });
</script>