<p class="title mb-2 text-center text-[1rem] font-bold text-[#252525] 2xl:text-[1.3rem]">
    Đánh giá giảng viên
</p>

<p class="desc mb-6 text-center text-[0.875rem]">
    Vui lòng để lại cảm nghĩ của bạn nhé! Đánh giá của bạn góp phần cải thiện chất
    lượng giảng dạy của giảng viên chúng tôi.
</p>
<form action="{{ url('cmrs/source/danh-gia-khoa-hoc') }}" method="POST" class="form form-validate" absolute check data-success="RATING_COURSE.ratingTeacher">
    @csrf
    <input type="hidden" name="map_table" value="users">
    <input type="hidden" name="map_id" value="{{ $currentItem->teacher_id }}">
    <input type="hidden" name="name_rating" value="rate">
    <div class="my-2 flex w-full justify-center text-center">
        @include('commentRS::selectStar', ['size' => 32,'name' => 'rate'])
    </div>
    <textarea rules="required" class="form-control mb-4 h-24 w-full resize-none rounded-lg bg-[#F5F5F5] p-3 outline-none" name="content" placeholder="Nhập ghi chú và nhấn Enter để lưu lại "></textarea>
    <button class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold uppercase text-white shadow-[0_6px_20px_rgba(178,30,37,.4)]">GỬI ĐÁNH GIÁ</button>
</form>
