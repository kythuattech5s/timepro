<?php

$nameField = FCHelper::er($table,'name');
$defaultData = 	json_decode($table->default_data, true);
$dataPivots = [];
$realValuePuts = [];
if (is_array($defaultData)) {
	$pivotTable = $defaultData['pivot_table'];
	$originField = $defaultData['origin_field'];
	$targetTable = $defaultData['target_table'];
	$targetField = $defaultData['target_field'];
	$targetSelect = $defaultData['target_select'];
	$columns = [];
	foreach ($targetSelect as $key => $value) {
		$columns[] = $value;
	}
	$dataPivots = FCHelper::getDataPivot($pivotTable, $originField, $targetTable, $targetField, $columns);
	if (count((array)$dataItem) > 0) {
		$realValuePuts = FCHelper::getRealValuePuts($dataItem, $pivotTable, $originField, $targetField);
	}
}
?>
<div class="form-group">
	<p class="form-title" for=""><?php echo e(FCHelper::er($table,'note')); ?> <span class="count"></span></p>
    <div class="box-search-pivot">
    	<textarea name="<?php echo e($nameField); ?>" class="hidden"><?php echo e(implode(',', $realValuePuts)); ?></textarea>
    	<input type="text" class="search<?php echo e($nameField); ?>" placeholder="Gõ để tìm kiếm" />
    	<button type="button" class="btnadmin choose<?php echo e($nameField); ?>">Bỏ chọn</button>
    </div>
    <ul class="listitem multiselect padding0 listitem<?php echo e($nameField); ?> <?php if($nameField == 'pivot_product_category'): ?> checkAjax <?php endif; ?>">
    	<?php if(in_array('parent', $columns)): ?>
    		<?php echo e(FCHelper::recursivePivotPrint($dataPivots, $realValuePuts)); ?>

    	<?php else: ?>
    		<?php echo e(FCHelper::pivotPrint($dataPivots, $realValuePuts)); ?>

    	<?php endif; ?>
    </ul>
    <script type="text/javascript">
        $(function () {
            function build<?php echo e($nameField); ?>() {
                var choose<?php echo e($nameField); ?> = $('.listitem<?php echo e($nameField); ?> input:checked');
                var str = '';
                for (var i = 0; i < choose<?php echo e($nameField); ?>.length; i++) {
                	if (str == '') {
                		str = $(choose<?php echo e($nameField); ?>[i]).val();
                	}
                	else{
                		str += ','+$(choose<?php echo e($nameField); ?>[i]).val();
                	}
                }
                return str;
            }
            if ($("textarea[name=<?php echo e($nameField); ?>]").val().length > 0) {
                $(".choose<?php echo e($nameField); ?>").removeClass("hidden");
            } else {
                $(".choose<?php echo e($nameField); ?>").addClass("hidden");
            }
            function checkedAllParentByChild<?php echo e($nameField); ?>(parent, level) {
                while (level > 0) {
                    level--;
                    var parentLevelClass = ".level-" + level;
                    var parentLevel = parent.prevAll(parentLevelClass).first();
                    var input = parentLevel.find("input").first();
                    if (!input.prop("checked")) {
                        input.prop("checked", true);
                    }
                }
            }
            function unCheckedParentIfNoChildChecked<?php echo e($nameField); ?>(parent, level) {
                while (level > 0) {
                    level--;
                    var parentLevelClass = ".level-" + level;
                    var parentLevel = parent.prevAll(parentLevelClass).first();
                    var parentLevelIndex = parentLevel.index();
                    var parentLevelIndexByClass = parentLevel.index(parentLevelClass);
                    var nextParent = $(parentLevelClass).eq(parentLevelIndexByClass + 1);
                    var lies = parentLevel.parent().find("li");
                    var nextIndex = lies.length;
                    if (nextParent.length > 0) {
                        nextIndex = nextParent.index();
                    }
                    var needUncheckParent = false;
                    for (var i = parentLevelIndex + 1; i < nextIndex; i++) {
                        var input = lies.eq(i).find("input").first();
                        if (input.prop("checked")) {
                            needUncheckParent = true;
                            break;
                        }
                    }
                    if (!needUncheckParent) {
                        var parentInput = parentLevel.find("input").first();
                        parentInput.prop("checked", false);
                    }
                }
            }
            function checkedParent<?php echo e($nameField); ?>(element) {
                var currentValue = $(element).is(":checked");
                var parent = $(element).parents("li");
                var level = parent.data("level");
                level = parseInt(level);
                if (currentValue) {
                    checkedAllParentByChild<?php echo e($nameField); ?>(parent, level);
                } else {
                    unCheckedParentIfNoChildChecked<?php echo e($nameField); ?>(parent, level);
                }
            }
            $("body").on("click", ".listitem<?php echo e($nameField); ?> li input", function (event) {
                checkedParent<?php echo e($nameField); ?>(this);
                var str = build<?php echo e($nameField); ?>();
                $("textarea[name=<?php echo e($nameField); ?>]").val(str);
                if (str.length > 0) {
                    $(".choose<?php echo e($nameField); ?>").removeClass("hidden");
                } else {
                    $(".choose<?php echo e($nameField); ?>").addClass("hidden");
                }
            });
            $(".choose<?php echo e($nameField); ?>").click(function (event) {
                event.preventDefault();
                var arr = $(".listitem<?php echo e($nameField); ?> li input").prop("checked", false);
                $(".listitem<?php echo e($nameField); ?> li").removeClass("choose");
                $("textarea[name=<?php echo e($nameField); ?>]").val("");
                $(this).addClass("hidden");
            });
            $(".listitem<?php echo e($nameField); ?> li span.expand").click(function (event) {
                event.preventDefault();
                var text = $(this).text();
                var liparent = $(this).parents("li");
                var level = liparent.data("level");
                var idx = liparent.index(".level-" + level);
                var iidx = liparent.index();
                var nitem = $(".level-" + level).eq(idx + 1);
                if (nitem.length > 0) {
                    var nidx = nitem.index();
                    var pitem = liparent.next(".level-" + (level - 1));
                    var pidx = pitem.index();
                    nidx = nidx > pidx && pidx != -1 ? pidx : nidx;
                    for (var i = iidx + 1; i < nidx; i++) {
                        if (text == "+") {
                            $(".listitem<?php echo e($nameField); ?> li").eq(i).show();
                            $(".listitem<?php echo e($nameField); ?> li").eq(i).find("span.expand").text("-");
                        } else {
                            $(".listitem<?php echo e($nameField); ?> li").eq(i).hide();
                            $(".listitem<?php echo e($nameField); ?> li").eq(i).find("span.expand").text("+");
                        }
                    }
                }
                if (text == "+") $(this).text("-");
                else $(this).text("+");
            });
            $("body").on("input", ".search<?php echo e($nameField); ?>", function (event) {
                event.preventDefault();
                var val = $(this).val().toLowerCase();
                if (val == "") {
                    $(this).parent().next().find("li").show();
                } else {
                    var lis = $(this).parent().next().find("li");
                    for (var i = 0; i < lis.length; i++) {
                        var li = $(lis[i]);
                        var text = li.text().toLowerCase();
                        if (text.indexOf(val) != -1) {
                            li.show();
                        } else {
                            li.hide();
                        }
                    }
                }
            });
            // function showAttribute(){
            //     $(document).ready(function(){
            //         var main = $('.checkAjax input[type="checkbox"]:checked');
            //         var product_id = $('.one.hidden').attr('dt-id');
            //         arrayId = [];
            //         $.each(main,function(key,value){
            //             arrayId.push($(value).val());
            //         })
            //         console.log(arrayId);
            //         $.post({
            //             url:'/esystem/showAttribute',
            //             data:{
            //                 product_cateogory_id:arrayId,
            //                 product_id:product_id
            //             }
            //         }).done(function(json){
            //             $('.show-attribute').html(json.html)
            //         });
            //     })
            // }
            // showAttribute();

            function findAttributeChecked(){
                var main = $('.show-attribute input[type="checkbox"]:checked');
                console.log(main);
                arrayId = [];
                $.each(function(key,value){
                    arrayId.push($(value).val());
                });
                $('textarea[name="pivot_attribute"]').html(arrayId.toString());
            }

            $('.checkAjax input[type="checkbox"]').click(function(){
                showAttribute();
                findAttributeChecked();
            });
        });

       
    </script>
</div>
<style type="text/css">
.listitem.multiselect {
    height: 200px;
    min-width: 200px;
    border: 1px solid #aaa;
    padding: 10px;
    overflow: hidden;
}
.listitem<?php echo e($nameField); ?>{
	overflow: scroll !important;
}
.listitem<?php echo e($nameField); ?> li:nth-child(odd){
			background: #f8f7f7;
		}
	.listitem<?php echo e($nameField); ?> li.choose{
		    background: #d9d9d9ab;
	}
		.listitem<?php echo e($nameField); ?> li{
			position: relative;
		}
		
.listitem<?php echo e($nameField); ?> span.expand{
	    position: absolute;
    right: 0;
    background: #00923f;
    color: #fff;
    font-size: 18px;
    width: 24px;
    text-align: center;
    cursor: pointer;
    user-select: none;
}
</style><?php /**PATH C:\laragon\www\timepro\/packages/vanhenry/views/ctedit/pivot.blade.php ENDPATH**/ ?>