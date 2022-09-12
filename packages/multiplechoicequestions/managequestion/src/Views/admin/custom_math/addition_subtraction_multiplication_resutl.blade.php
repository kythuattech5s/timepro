<span class="custom-math-tech5s-matrix">
	<span class="addition-subtraction-multiplication-content max-size-{{$maxSize}}">
		<span class="box-top">
			<span class="operator">
				{{$operator}}
			</span>
			<span class="main-top">
				<span class="item-row">
		@foreach ($arrLine1 as $item)
			<span class="item-col">{!!$item!!}</span>
		@endforeach
		</span>
				<span class="item-row">
		@foreach ($arrLine2 as $item)
			<span class="item-col">{!!$item!!}</span>
		@endforeach
		</span>
			</span>
		</span>
		<span class="item-row box-bottom">
	@foreach ($arrLine3 as $item)
		<span class="item-col">{!!$item!!}</span>
	@endforeach
	</span>
	</span>
</span>