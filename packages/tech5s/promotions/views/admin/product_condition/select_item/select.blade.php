<span class="rule-param">
	<a href="javascript:void(0)" class="active"> ... </a>
	<span class="element"> 
  		<select class="item-condition-value">
  			@foreach ($productConditionType->getListItemSelecter($mapId) as $itemSelecter)
				<option value="{{$itemSelecter->id}}" {{$defaultValue == $itemSelecter->id ? 'selected':''}}>{{$itemSelecter->name}}</option>
			@endforeach
		</select>
	</span>
</span>