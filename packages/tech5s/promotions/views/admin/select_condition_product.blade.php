<?php 
	use Tech5sMarketing\Tech5sPromotion\Models\{ProductConditionType,ProductCondition};
	use Tech5sMarketing\Tech5sPromotion\Helpers\Helper;
	$name = FCHelper::er($table,'name');
	$value ="";	
	if($actionType=='edit'||$actionType=='copy'){
		$value = FCHelper::er($dataItem,$name);
		$valueContent = Helper::extractJson($value);
	}
	$listProductConditionType = ProductConditionType::where('act',1)->get();
	$listProductCondition = ProductCondition::get();
?>
<textarea id="content-catalog-price-rule" class="hidden control" name="<?php echo $name; ?>">{{$value}}</textarea>
<script type="text/javascript">
	var baseurl = '{{url()->to('/')}}';
	var admincp = '{{$admincp}}';
</script>
<link rel="stylesheet" type="text/css" href="tech5sMarketing/css/select_condition_product.css">
<script type="text/javascript" src="tech5sMarketing/js/select_condition_product.js?v={{time()}}" defer></script>
<div class="form-group">
  	<p class="form-title" for="">{{FCHelper::er($table,'note')}}<span class="count"></span></p>
  	<p>- Nếu không chọn điều kiện nào, tất cả sản phẩm sẽ được áp dụng khuyến mãi.</p>
  	<div class="border-box">
  		<div class="main-condition-box">
  			<div class="header-box">
  				Nếu 
		  		<span class="rule-param">
			  		<a href="javascript:void(0)" class="active">Tất cả</a>
			  		<span class="element">
				  		<select class="main-condition-box-type">
							<option value="1" {{isset($valueContent['mainConditionType']) && $valueContent['mainConditionType'] == 1 ? 'selected':''}}>Tất cả</option>
							<option value="0" {{isset($valueContent['mainConditionType']) && $valueContent['mainConditionType'] == 0 ? 'selected':''}}>Bất kì</option>
						</select>
					</span>
				</span>
		  		điều kiện sau
		  		<span class="rule-param">
			  		<a href="javascript:void(0)" class="active">Đúng</a>
			  		<span class="element"> 
				  		<select class="main-condition-box-value">
							<option value="1" {{isset($valueContent['mainConditionValue']) && $valueContent['mainConditionValue'] == 1 ? 'selected':''}}>Đúng</option>
							<option value="0" {{isset($valueContent['mainConditionValue']) && $valueContent['mainConditionValue'] == 0 ? 'selected':''}}>Sai</option>
						</select>
					</span>
				</span>:
		  	</div>
		  	<div class="list-item-condition">
		  		<div class="list">
			  		@if (isset($valueContent['listCondition']))
			  			@foreach ($valueContent['listCondition'] as $valueDefaultCondition)
			  				@include('tech5spromotion::admin.product_condition.base_item_condition',['valueDefaultCondition'=>$valueDefaultCondition])
			  			@endforeach
			  		@endif
		  		</div>
		  		<div class="action-box-condition">
		  			<button type="button" class="btn-add-condition active"><i class="fa fa-plus" aria-hidden="true"></i></button>
		  			<select class="select-condition-type">
		  				<option value="">Vui lòng chọn một điều kiện để thêm</option>
						@foreach ($listProductConditionType as $itemProductConditionType)
							@php
								$listCondition = $itemProductConditionType->getInstance()->getConditionTypeCondition();
							@endphp
							@foreach ($listCondition as $itemCondition)
								<option value="{{$itemCondition->buildStrId()}}">{{$itemCondition->getName()}}</option>
							@endforeach
						@endforeach
					</select>
		  		</div>
	  		</div>
  		</div>
  	</div>
</div>