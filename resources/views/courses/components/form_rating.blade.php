 <div class="form-rating__teacher mb-6 p-4 lg:p-6 lg:px-10 2xl:mb-10 2xl:py-10 2xl:px-14">
     <p class="title mb-2 text-center text-[1rem] font-bold text-[#252525] 2xl:text-[1.3rem]">
         Đánh giá bài học
     </p>
     <p class="desc mb-6 text-center text-[0.875rem]">
         Vui lòng để lại cảm nghĩ của bạn nhé! Đánh giá của bạn góp phần cải thiện chất lượng bài học và
         giúp học viên khác dễ dàng lựa chọn khóa học.
     </p>
     <form action="{{ url('cmrs/source/danh-gia-khoa-hoc') }}" method="POST" class="form form-validate" absolute check data-success="RATING_COURSE.ratingDone">
         @csrf
         <input type="hidden" name="map_table" value="courses">
         <input type="hidden" name="map_id" value="{{ Support::show($currentItem, 'id') }}">
         <div class="flex items-center justify-center gap-3 text-center">
             <label for="" class="font-bold">Bài học</label>
             @include('commentRS::selectStar', ['size' => 32])
         </div>
         <textarea class="form-control mb-4 h-24 w-full resize-none rounded-lg bg-[#F5F5F5] p-3 outline-none" rules="required" name="content" placeholder="Nhập đánh giá của bạn "></textarea>
         <button type="submit" class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold uppercase text-white shadow-[0_6px_20px_rgba(178,30,37,.4)]">GỬI ĐÁNH GIÁ</button>
     </form>
 </div>