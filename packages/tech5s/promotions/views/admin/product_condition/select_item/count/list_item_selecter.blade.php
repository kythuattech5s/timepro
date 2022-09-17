<div class="header-box-list-item-selecter d-flex flex-wrap justify-content-between align-items-center p-3">
	<div class="box-search-item-selecter d-flex align-items-center flex-wrap">
		<input type="text" class="item-search-selecter-code mr-2" placeholder="Nhập mã sản phẩm" value="{{$code}}">
		<input type="text" class="item-search-selecter-name mr-3" placeholder="Nhập tên sản phẩm" value="{{$name}}">
		<button type="button" class="search-item-selecter mr-2 btn btn-info">Tìm kiếm</button>
		<button type="button" class="reset-search-item-selecter mr-2 btn btn-default">Reset</button>
		<p class="ml-3">Tổng: {{$listItems->total()}} bản ghi</p>
	</div>
	{{$listItems->withQueryString()->links('tech5spromotion::admin.pagination')}}
</div>
@if (count($listItems) > 0)
	<table class="table-item-selecter text-left">
		<thead>
			<tr>
				<th><input type="checkbox" class="select-all-selecter"></th>
				<th class="text-center">Id</th>
				<th>Mã sản phẩm</th>
				<th>Tên sản phẩm</th>
				<th>Giá</th>
                <th>Số lượng áp dụng</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($listItems as $item)
				<tr>
					<td><input type="checkbox" value="{{$item->code}}" class="select-item-selecter"></td>
					<td class="text-center">{{$item->id}}</td>
					<td>{{$item->code}}</td>
					<td>{{$item->name}}</td>
					<td>{{$item->price}}</td>
                    <td><input type="text" placeholder="Số lượng" count class="w-full rounded-md border-1"></td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<p class="no-item-seleter p-3">Không có item nào</p>
@endif