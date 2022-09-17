function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}
var SELECT_CONDITION_PRODUCT_BASE = {
	init(){
		SELECT_CONDITION_PRODUCT_BASE.initSelectParam();
		SELECT_CONDITION_PRODUCT_BASE.addItemcondition();
		SELECT_CONDITION_PRODUCT_BASE.deleteItem();
		SELECT_CONDITION_PRODUCT_BASE.reShowSelectParamValue();
	},
	initSelectParam(){
		$(document).on('click', '.rule-param a', function(event) {
			$(this).removeClass('active');
			$(this).closest('.rule-param').find('.element').addClass('active');
			SELECT_CONDITION_PRODUCT_BASE.reShowSelectParamValue();
		});
		$(document).on('change', '.rule-param select', function(event) {
			SELECT_CONDITION_PRODUCT_BASE.closeAllSelectParam();
			SELECT_CONDITION_PRODUCT_BASE.buildData();
		});
		$(document).click(function(event) { 
			var target = $(event.target);
			if(!target.closest('.rule-param').length) {
				SELECT_CONDITION_PRODUCT_BASE.closeAllSelectParam();
			}else{
				$('.rule-param').not(target.closest('.rule-param')).each(function(index, el) {
					$(this).find('.element').removeClass('active');
					$(this).find('a').addClass('active');
				});
			}
		});
	},
	closeAllSelectParam(){
		$('.rule-param').each(function(index, el) {
			$(this).find('.element').removeClass('active');
			$(this).find('a').addClass('active');
		});
		SELECT_CONDITION_PRODUCT_BASE.reShowSelectParamValue();
	},
	reShowSelectParamValue(){
		$('.rule-param').each(function(index, el) {
			var a = $(this).find('a');
			var text = $(this).find('select option:selected').text();
			a.html(text);
		});
	},
	resetConditionAddItem(){
		$('.btn-add-condition').addClass('active');
		$('.select-condition-type').removeClass('active');
	},
	addItemcondition(){
		$(document).on('click', '.btn-add-condition', function(event) {
			SELECT_CONDITION_PRODUCT_BASE.resetConditionAddItem();
			$(this).removeClass('active');
			$(this).closest('.action-box-condition').find('.select-condition-type').addClass('active');
		});
		$(document).click(function(event) { 
			var target = $(event.target);
			if(!target.closest('.action-box-condition').length) {
				SELECT_CONDITION_PRODUCT_BASE.resetConditionAddItem();
			}
		});
		$(document).on('change', '.select-condition-type', function(event) {
			var _this = $(this);
			var val = _this.val();
			_this.val('');
			_this.removeClass('active');
			$.ajax({
				url: 'sys-promotion/load-item-condition',
				type: 'POST',
				dataType: 'json',
				data: {val: val}
			})
			.done(function(data) {
				if (data.code == 200){
					_this.closest('.action-box-condition').prev('.list').append(data.html);
				}else{
					$.simplyToast(data.message, 'danger');
				}
				_this.closest('.action-box-condition').find('.btn-add-condition').addClass('active');
				SELECT_CONDITION_PRODUCT_BASE.buildData();
			})
		});
	},
	deleteItem(){
		$(document).on('click', '.item-condition .delete-item', function(event) {
			event.preventDefault();
			$(this).closest('.item-condition').remove();
			SELECT_CONDITION_PRODUCT_BASE.buildData();
		});
	},
	buildData(){
		var data = {};
		data.mainConditionType = $('.main-condition-box-type').val();
		data.mainConditionValue = $('.main-condition-box-value').val();
		var listCondition = {};
		var itemConditions = $('.main-condition-box .item-condition');
		for (var j= 0; j < itemConditions.length; j++) {
			var itemCondition = $(itemConditions[j]);
			var tmp = {};
			tmp.type = itemCondition.data('item');
			tmp.mapId = itemCondition.data('map');
			tmp.condition = itemCondition.find('.item-condition-condition').val();
			tmp.value = itemCondition.find('.item-condition-value').val();
			listCondition[j] = tmp;
		}
		data.listCondition = listCondition;
		$('#content-catalog-price-rule').text(JSON.stringify({...data}));
	},
	rebuildDataInputSelecter(target,value,type){
		var valueList = target.val();
		var valueListArr = valueList.split(',');
		if (type == 'add') {
			target.val(valueList+(valueList=='' ? '':',')+value);
		}
		if (type == 'remove') {
			var indexRemoveValue = valueListArr.indexOf(value,0);
			valueListArr.splice(indexRemoveValue,1);
			target.val(valueListArr.join());
		}
		valueList = target.val().split(',');
		var uniqueValue = [];
		for(var i = 0; i < valueList.length; i++) {
	        if (!inArray(valueList[i],uniqueValue)) {
	        	uniqueValue.push(valueList[i]);
	        }
	    }
		target.val(uniqueValue.join());
		SELECT_CONDITION_PRODUCT_BASE.buildData();
	}
}
var SELECT_CONDITION_PRODUCT_SELECT_BOX = {
	init(){
		SELECT_CONDITION_PRODUCT_SELECT_BOX.initSelectBox();
		SELECT_CONDITION_PRODUCT_SELECT_BOX.reShowSelectBoxValue();
	},
	initSelectBox(){
		$(document).on('click', '.select-box-container .content-select-box', function(event) {
			$(this).removeClass('active');
			$(this).closest('.select-box-container').find('.select-box-main').addClass('active');
			SELECT_CONDITION_PRODUCT_SELECT_BOX.reShowSelectBoxValue();
		});
		$(document).on('click', '.select-box-container .btn-accept', function(event) {
			var parent = $(this).closest('.select-box-container');
			parent.find('.select-box-main').removeClass('active');
			parent.find('.content-select-box').addClass('active');
			parent.closest('.item-condition').find('.list-item-selecter-selectbox').remove();
			SELECT_CONDITION_PRODUCT_SELECT_BOX.reShowSelectBoxValue();
		});
		$(document).click(function(event) { 
			var target = $(event.target);
			if(!target.closest('.select-box-container').length && !target.closest('.list-item-selecter-selectbox').length) {
				SELECT_CONDITION_PRODUCT_SELECT_BOX.closeAllSelectBox();
			}else{
				$('.select-box-container').not(target.closest('.select-box-container')).not(target.closest('.list-item-selecter-selectbox').closest('.item-condition').find('.select-box-container')).each(function(index, el) {
					$(this).find('.select-box-main').removeClass('active');
					$(this).find('.content-select-box').addClass('active');
					$(this).closest('.item-condition').find('.list-item-selecter-selectbox').remove();
				});
			}
		});
		$(document).on('click', '.select-box-container .open-list-item-selecter', function(event) {
			event.preventDefault();
			var itemCondition = $(this).closest('.item-condition');
			var item = itemCondition.data('item');
			var map = itemCondition.data('map');
			$.ajax({
				url: 'sys-promotion/load-item-selecter',
				type: 'GET',
				dataType: 'html',
				data: {
					item:item,
					map:map
				}
			})
			.done(function(html) {
				if(itemCondition.find('.list-item-selecter-selectbox').length == 0){
					itemCondition.append(`<div class="list-item-selecter-selectbox"></div>`);
				}
				var targetBox = itemCondition.find('.list-item-selecter-selectbox');
				targetBox.html(html);
				SELECT_CONDITION_PRODUCT_SELECT_BOX.reCheckBoxValue(targetBox);
			})
		});
		$(document).on('click', '.box-search-item-selecter .search-item-selecter', function(event) {
			event.preventDefault();
			var itemCondition = $(this).closest('.item-condition');
			var item = itemCondition.data('item');
			var map = itemCondition.data('map');
			var code = itemCondition.find('.item-search-selecter-code').val();
			var name = itemCondition.find('.item-search-selecter-name').val();
			$.ajax({
				url: 'sys-promotion/load-item-selecter',
				type: 'GET',
				dataType: 'html',
				data: {
					item:item,
					map:map,
					code:code,
					name:name
				}
			})
			.done(function(html) {
				var targetBox = itemCondition.find('.list-item-selecter-selectbox');
				targetBox.html(html);
				SELECT_CONDITION_PRODUCT_SELECT_BOX.reCheckBoxValue(targetBox);
			})
		});
		$(document).on('click', '.box-search-item-selecter .reset-search-item-selecter', function(event) {
			event.preventDefault();
			var itemCondition = $(this).closest('.item-condition');
			var item = itemCondition.data('item');
			var map = itemCondition.data('map');
			$.ajax({
				url: 'sys-promotion/load-item-selecter',
				type: 'GET',
				dataType: 'html',
				data: {
					item:item,
					map:map
				}
			})
			.done(function(html) {
				var targetBox = itemCondition.find('.list-item-selecter-selectbox');
				targetBox.html(html);
				SELECT_CONDITION_PRODUCT_SELECT_BOX.reCheckBoxValue(targetBox);
			})
		});
		$(document).on('click', '.list-item-selecter-selectbox a', function(event) {
			event.preventDefault();
			var itemCondition = $(this).closest('.item-condition');
			$.ajax({
				url: $(this).attr('href'),
				type: 'GET',
				dataType: 'html'
			})
			.done(function(html) {
				var targetBox = itemCondition.find('.list-item-selecter-selectbox');
				targetBox.html(html);
				SELECT_CONDITION_PRODUCT_SELECT_BOX.reCheckBoxValue(targetBox);
			})
		});
		$(document).on('click', '.select-all-selecter', function(event) {
			if ($(this).is(':checked')) {
				$(this).closest('.table-item-selecter').find('.select-item-selecter').prop('checked',true).trigger('change');
			}else{
				$(this).closest('.table-item-selecter').find('.select-item-selecter').prop('checked',false).trigger('change');
			}
		});
		$(document).on('change', '.table-item-selecter .select-item-selecter', function(event) {
			var target = $(this).closest('.item-condition').find('.ip-content-select-box');
			var value = $(this).val();
			var type;
			if ($(this).is(':checked')) {
				type = 'add';
			}else{
				type = 'remove';
			}
			SELECT_CONDITION_PRODUCT_BASE.rebuildDataInputSelecter(target,value,type);
		});
	},
	closeAllSelectBox(){
		$('.select-box-container').each(function(index, el) {
			$(this).find('.select-box-main').removeClass('active');
			$(this).find('.content-select-box').addClass('active');
			$(this).closest('.item-condition').find('.list-item-selecter-selectbox').remove();
		});
		SELECT_CONDITION_PRODUCT_SELECT_BOX.reShowSelectBoxValue();
	},
	reShowSelectBoxValue(){
		$('.select-box-container').each(function(index, el) {
			var contentSelectBox = $(this).find('.content-select-box');
			var text = $(this).find('.ip-content-select-box').val();
			if (text == '') {
				text = '...';
			}
			contentSelectBox.html(text);
		});
	},
	reCheckBoxValue(targetBox){
		var valueList = targetBox.closest('.item-condition').find('.ip-content-select-box').val().split(',');
		var countChecked = 0;
		targetBox.find('.select-item-selecter').each(function(index, el) {
			if (inArray($(this).val(), valueList)) {
				$(this).prop('checked',true);
				countChecked++;
			}
		});
		if (countChecked == targetBox.find('.select-item-selecter').length) {
			targetBox.find('.select-all-selecter').prop('checked',true);
		}
	},
	
}
var SELECT_CONDITION_PRODUCT_SELECT_PARENT = {
	init(){
		SELECT_CONDITION_PRODUCT_SELECT_PARENT.initSelectBox();
		SELECT_CONDITION_PRODUCT_SELECT_PARENT.reShowSelectParentValue();
	},
	initSelectBox(){
		$(document).on('click', '.select-parent-container .content-select-parent', function(event) {
			$(this).removeClass('active');
			$(this).closest('.select-parent-container').find('.select-parent-main').addClass('active');
			SELECT_CONDITION_PRODUCT_SELECT_PARENT.reShowSelectParentValue();
		});
		$(document).on('click', '.select-parent-container .btn-accept-parent', function(event) {
			var parent = $(this).closest('.select-parent-container');
			parent.find('.select-parent-main').removeClass('active');
			parent.find('.content-select-parent').addClass('active');
			parent.closest('.item-condition').find('.list-item-selecter-selectparent').remove();
			SELECT_CONDITION_PRODUCT_SELECT_PARENT.reShowSelectParentValue();
		});
		$(document).click(function(event) { 
			var target = $(event.target);
			if(!target.closest('.select-parent-container').length && !target.closest('.list-item-selecter-selectparent').length) {
				SELECT_CONDITION_PRODUCT_SELECT_PARENT.closeAllSelectParent();
			}else{
				$('.select-parent-container').not(target.closest('.select-parent-container')).not(target.closest('.list-item-selecter-selectparent').closest('.item-condition').find('.select-parent-container')).each(function(index, el) {
					$(this).find('.select-parent-main').removeClass('active');
					$(this).find('.content-select-parent').addClass('active');
					$(this).closest('.item-condition').find('.list-item-selecter-selectparent').remove();
				});
			}
		});
		$(document).on('click', '.select-parent-container .open-list-item-parent-selecter', function(event) {
			event.preventDefault();
			var itemCondition = $(this).closest('.item-condition');
			var item = itemCondition.data('item');
			var map = itemCondition.data('map');
			$.ajax({
				url: 'sys-promotion/load-item-selecter',
				type: 'GET',
				dataType: 'html',
				data: {
					item:item,
					map:map
				}
			})
			.done(function(html) {
				if(itemCondition.find('.list-item-selecter-selectparent').length == 0){
					itemCondition.append(`<div class="list-item-selecter-selectparent"></div>`);
				}
				var targetBox = itemCondition.find('.list-item-selecter-selectparent');
				targetBox.html(html);
				SELECT_CONDITION_PRODUCT_SELECT_PARENT.reCheckBoxValue(targetBox);
			})
		});
		$(document).on('click', '.list-item-selecter-selectparent .btn-drop-child-cate', function(event) {
			var ulTarget = $(this).closest('li').find('> ul');
			if ($(this).hasClass('active')) {
				ulTarget.slideUp(300);
			}else {
				ulTarget.slideDown(300);
			}
			$(this).toggleClass('active');
		});
		$(document).on('change', '.list-item-selecter-selectparent input', function(event) {
			var target = $(this).closest('.item-condition').find('.ip-content-select-parent');
			var value = $(this).val();
			var type;
			if ($(this).is(':checked')) {
				type = 'add';
			}else{
				type = 'remove';
			}
			SELECT_CONDITION_PRODUCT_BASE.rebuildDataInputSelecter(target,value,type);
		});
	},
	reShowSelectParentValue(){
		$('.select-parent-container').each(function(index, el) {
			var contentSelectBox = $(this).find('.content-select-parent');
			var text = $(this).find('.ip-content-select-parent').val();
			if (text == '') {
				text = '...';
			}
			contentSelectBox.html(text);
		});
	},
	closeAllSelectParent(){
		$('.select-parent-container').each(function(index, el) {
			$(this).find('.select-parent-main').removeClass('active');
			$(this).find('.content-select-parent').addClass('active');
			$(this).closest('.item-condition').find('.list-item-selecter-selectparent').remove();
		});
		SELECT_CONDITION_PRODUCT_SELECT_PARENT.reShowSelectParentValue();
	},
	reCheckBoxValue(targetBox){
		var valueList = targetBox.closest('.item-condition').find('.ip-content-select-parent').val().split(',');
		var countChecked = 0;
		targetBox.find('input').each(function(index, el) {
			if (inArray($(this).val(), valueList)) {
				$(this).prop('checked',true);
				countChecked++;
				$(this).parents('ul').each(function(index, el) {
					$(this).slideDown(300);
				});
			}
		});
	}
}
$(document).ready(function() {
	SELECT_CONDITION_PRODUCT_BASE.init();
	SELECT_CONDITION_PRODUCT_SELECT_BOX.init();
	SELECT_CONDITION_PRODUCT_SELECT_PARENT.init();
});