<span class="custom-math-tech5s-matrix">
	<span class="number-concatenation">
		@foreach ($arrVal as $key => $item)
			<span class="item-box {{$key %2 == 0 ? 'number-box':'arrow-box'}}">@if ($key %2 == 0){{$item}}
				@else<span class="arrow-box-content">{{$item}}</span>@endif
			</span>
		@endforeach
	</span>
</span>