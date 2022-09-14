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
        padding: 6px;
    }
    .table-manage-time-package td{
        padding: 6px;
    }
    .btn-add-item-time-package,.btn-delete-item-time-package{
        font-size: 16px;
    }
</style>
<div class="manage-time-package">
    <table class="table-manage-time-package">
        <thead>
            <tr>
                <th>Tên gói</th>
                <th colspan="2">Thời gian</th>
                <th>Giá</th>
                <th>Giá cũ</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    <div class="text-center mt-3">
        <button type="button" class="btn btn-info px-5 btn-add-item-time-package">Thêm gói</button>
    </div>
</div>
<script>
    var MANAE_ITEM_PACKAGE = (function(){
        var baseItemTimePackage = `
            <tr class="item-manage-time-package">
                <td>
                    <input type="text" class="name" placeholder="Tên gói">
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <span>Nhập số ngày:</span>
                        <input type="number" class="number_day ms-2" placeholder="Số ngày">
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <span>Hoặc chọn vĩnh viễn</span>
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
        var initBtnAddItem = function(){
            $('.btn-add-item-time-package').click(function(){
                $('.table-manage-time-package tbody').append(baseItemTimePackage);
            });
        }
        var initBtnDeleteItem = function(){
            $(document).on('click','.btn-delete-item-time-package',function(){
                $(this).closest('.item-manage-time-package').remove();
            });
            }
        return {
            _(){
                initBtnAddItem();
                initBtnDeleteItem();
		    }
	    };
    })();
    $(document).ready(function () {
        MANAE_ITEM_PACKAGE._();
    });
</script><?php /**PATH C:\laragon\www\timepro\packages\course_manage\src\Providers/../AdminViews/ctedit/course_manage/manage_time_package.blade.php ENDPATH**/ ?>