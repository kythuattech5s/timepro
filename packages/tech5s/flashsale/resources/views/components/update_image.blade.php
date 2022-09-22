<div class="voucher-image flex-column align-items-center flex justify-center">
    <label for="voucher-image" class="voucher-image__title w-full text-center">Ảnh chương
        trình</label>
    @if (isset($currentItem))
        <img style="object-fit:cover" class="h-[150px]" src="{{ !empty($currentItem->img) ? FCHelper::eimg2($currentItem, 'img') : 'admin/promotion/assets/images/image-default.svg' }}">
        <input placeholder="Thêm hình ảnh" class="form-control" value="{{ $currentItem->img }}" type="hidden" name="img" id="voucher-image">
    @else
        <img style="object-fit:cover" class="h-[150px]" src="admin/promotion/assets/images/image-default.svg">
        <input placeholder="Thêm hình ảnh" class="form-control" type="hidden" name="img" id="voucher-image">
    @endif
    <div class="form-group textcenter">
        <a href="{{ $admincp }}/media/view?istiny=voucher-image" class="browseimage bgmain btn iframe-btn bg-orange-400 text-white" type="button">{{ trans('db::choose_img') }}</a>
        <button type="button" class="btnchange-voucher-image bgmain btn mt-[15px] ml-[5px] bg-red-400 text-white">{{ trans('db::edit') }}</button>
        <button type="button" class="btndelete-voucher-image bgmain btn mt-[15px] ml-[5px] bg-blue-400 text-white">{{ trans('db::delete') }}</button>
    </div>
</div>
<script type="text/javascript">
    function close_window() {
        parent.$.fancybox.close();
    }

    function hungvtApplyCallbackFile(arrItem, field_id) {
        if (arrItem.length == 0) return;
        var nxt = $('#' + field_id).prev();
        if ($(nxt).prop('tagName').toLowerCase() == 'img') {
            var item = arrItem[0];
            var def = $("[name=name]").val();
            if (def != undefined) {
                item.alt = def;
                item.title = def;
                item.caption = def;
                item.description = def;
            }
            $('#' + field_id).val(JSON.stringify(item)).trigger('change').trigger("input");
            $(nxt).attr('src', item.path + item.file_name);
        } else {
            var item = arrItem[0];
            var def = $("[name=name]").val();
            if (def != undefined) {
                item.alt = def;
                item.title = def;
                item.caption = def;
                item.description = def;
            }
            $('img#' + field_id).attr('src', item.path + item.file_name);
            $('img#' + field_id).attr('dt-value', JSON.stringify(item));

            var name_gallery = $('img#' + field_id).attr('rel');

            var arr = $('.gallery-' + name_gallery).find('>li');
            var ret = [];
            for (var i = 0; i < arr.length; i++) {
                var item = $(arr[i]);
                var img = item.find('img');
                var obj = JSON.parse(img.attr('dt-value'));
                ret.push(obj);
            }
            $('input[name=' + name_gallery + ']').val(JSON.stringify(ret));
        }
    }

    function changeListImageV2(_that, inputarget) {
        var arr = $(_that).find('img');
        var str = new Array();
        for (var i = 0; i < arr.length; i++) {
            var item = arr[i];
            var tmp = JSON.parse($(item).attr('data-file'));
            str.push(tmp);
        };
        str = JSON.stringify(str);
        $('input[name=' + inputarget + ']').val(str);
    }

    $(function() {
        $('.btndelete-voucher-image').click(function(event) {
            event.preventDefault();
            $("input[name='img']").val("");
            $("input[name='img']").prev().attr("src", "/admin/promotion/assets/images/image-default.svg");
        });
        $(".btnchange-voucher-image").click(function(event) {
            event.preventDefault();
            var file = $('input[name="img"]').val();
            try {
                file = JSON.parse(file);
            } catch (ex) {
                file = {};
                file.title = "";
                file.caption = "";
                file.alt = "";
                file.description = "";
            }
            var dialog = bootbox.dialog({
                title: "Chỉnh sửa thông tin ảnh",
                onEscape: true,
                message: '<div class="row">' +
                    '<div class="col-md-6 col-xs-12 form-group">' +
                    '	<label for="">Tiêu đề</label>' +
                    '	<input name="title" type="text" class="form-control" value="' + (file.title == null ? '' : file.title) + '" placeholder="Title">' +
                    '	</div>' +
                    '	<div class="col-md-6 col-xs-12 form-group">' +
                    '		<label for="">Đầu đề</label>' +
                    '		<input name="caption" type="text" class="form-control" value="' + (file.caption == null ? '' : file.caption) + '" placeholder="Caption">' +
                    '	</div>' +
                    '	<div class="col-md-6 col-xs-12 form-group">' +
                    '		<label for="">Thông tin thay thế</label>' +
                    '		<input name="alt" type="text" class="form-control" value="' + (file.alt == null ? '' : file.alt) + '" placeholder="Alt">' +
                    '	</div>' +
                    '	<div class="col-md-6 col-xs-12 form-group">' +
                    '		<label for="">Nội dung</label>' +
                    '		<input name="description" type="text" class="form-control" value="' + (file.description == null ? '' : file.description) + '" placeholder="Description">' +
                    '	</div>' +
                    '</div>',
                buttons: {
                    confirm: {
                        label: '{{ trans('db::save') }}',
                        className: 'btn-success',
                        callback: function() {
                            file.title = dialog.find("input[name=title]").val();
                            file.caption = dialog.find("input[name=caption]").val();
                            file.alt = dialog.find("input[name=alt]").val();
                            file.description = dialog.find("input[name=description]").val();
                            $('input[name="img"]').val(JSON.stringify(file));
                        }
                    },
                    cancel: {
                        label: '{{ trans('db::close') }}',
                        callback: function() {
                            dialog.modal("hide");
                        }
                    }
                },
            });
            dialog.modal("show");
        });
    });
</script>
