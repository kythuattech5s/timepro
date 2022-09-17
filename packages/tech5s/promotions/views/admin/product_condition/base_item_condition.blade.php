@php
    $countValue = '';
	if(isset($valueDefaultCondition)){
		$productConditionTypeModal = \Tech5sMarketing\Tech5sPromotion\Models\ProductConditionType::find($valueDefaultCondition['type']);
		$productConditionType = $productConditionTypeModal->getInstance();
		$mapId = $valueDefaultCondition['mapId'];
		$nameShow = $productConditionType->getNameShow($mapId);
		$defaultValue = $valueDefaultCondition['value'];
		$countValue = $valueDefaultCondition['count'] ?? '';
	}
@endphp
<div class="item-condition" data-item="{{$productConditionType->getModel()->id ?? 0}}" data-map="{{$mapId}}">
	<div class="content-item">
		<span class="item-condition-name">
			{{$nameShow}}
		</span>
		@php
			$listCondition = $productConditionType->getConditionList();
		@endphp
		<span class="rule-param">
	  		<a href="javascript:void(0)" class="active">{{count($listCondition) > 0 ? $listCondition->first()->name:''}}</a>
	  		<span class="element"> 
		  		<select class="item-condition-condition">
		  			@foreach ($listCondition as $condition)
						<option value="{{$condition->id}}" {{isset($valueDefaultCondition['condition']) && $valueDefaultCondition['condition'] == $condition->id ? 'selected':''}}>{{$condition->name}}</option>
					@endforeach
				</select>
			</span>
		</span>
        @php
        @endphp
		<div class="list-item-select">
			<div class="select-item-box {{$productConditionType->getTypeShow()}}">
				@include('tech5spromotion::admin.product_condition.select_item.'.$productConditionType->getTypeShow(),['productConditionType'=>$productConditionType,'mapId'=>$mapId,'defaultValue'=>$defaultValue, 'countValue' => $countValue])
			</div>
			<div class="delete-item">
				<i class="fa fa-times" aria-hidden="true"></i>
			</div>
		</div>
	</div>
</div>