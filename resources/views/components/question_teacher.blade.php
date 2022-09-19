<div class="mb-2 flex justify-between">
    <p class="font-bold">
        Đặt câu hỏi
    </p>
    <input type="hidden" name="map_table" value="{{ $map_table ?? 'courses' }}" rs-qaa-filter>
    <input type="hidden" name="map_id" value="{{ $currentItem->id }}" rs-qaa-filter>
    <div class="flex items-center gap-2">
        <span>Sắp xếp theo:</span>
        <select name="sort" id="" class="rounded-md bg-[#F2F2F2] p-2" rs-qaa-filter>
            <option value="DESC">Mới nhất</option>
            <option value="ASC">Cũ nhất</option>
        </select>
    </div>
</div>
@if (Auth::check())
    @php
        $user = Auth::user();
    @endphp
    <div>
        <form action="hoi-dap" method="POST" class="form-validate flex items-center gap-4" data-success="ASK_AND_ANSWER.showNotify" clear absolute>
            @csrf
            <input type="hidden" name="model" value="\App\Models\QuestionTeacher">
            <input type="hidden" name="label" value="câu hỏi cho giảng viên">
            <input type="hidden" name="map_table" value="courses">
            <input type="hidden" name="map_id" value="{{ $currentItem->id }}">
            <img src="{%IMGV2.user.img.-1%}" class="border-md h-12 w-12" alt="{%AIMGV2.user.img.alt%}" title="{%AIMGV2.user.img.title%}">
            <div class="flex flex-1 items-center rounded-lg bg-[#F5F5F5] px-4 py-3">
                <textarea name="content" class="h-6 flex-1 resize-none bg-transparent outline-none" rules="required" placeholder="Đặt câu hỏi..."></textarea>
                <button type="submit" class="button-text-gradient px-4">Gửi</button>
            </div>
        </form>
    </div>
@else
@endif
<div class="mt-12 flex flex-col gap-3" list-question-for-teacher>
    @include('components.question_item')
    @if (!$listItems->onLastPage())
        <button class="mx-auto mt-6 block w-fit text-[0.875rem] font-semibold text-[#252525]" ask-load-more data-table="courses" data-id="{{ $currentItem->id }}" data-next-page="{{ $listItems->currentPage() + 1 }}">Xem thêm <i class="fa fa-angle-down" aria-hidden="true"></i></button>
    @endif
</div>
