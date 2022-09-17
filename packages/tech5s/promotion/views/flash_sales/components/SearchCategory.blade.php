<div class="my-3 flex gap-1">
	<input type="text" data-name="name" class="flex-1 rounded-[5px] border py-2 px-10" placeholder="Nhập tên danh mục cần tìm kiếm" data-category="name">
	<button type="button" class="submit-search rounded-[5px] bg-green-300 py-2 px-5">Tìm kiếm</button>
</div>
<div class="my-3">
	<label for="selected-category" class="flex items-center space-x-3">
		<span>Chỉ hiển thị danh mục đã chọn</span>
		<input type="checkbox" id="selected-category" data-category="isShow" @if (isset($currentItem)) checked @endif>
	</label>
</div>
