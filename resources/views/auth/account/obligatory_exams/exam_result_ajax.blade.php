<div class="text-center">
    <p class="title font-bold text-[#252525] lg:text-[1.25rem] text-center mb-3">Kết bài thi: {{Support::show($obligatoryExam,'name')}}</p>
    <p class="font-semibold text-[#252525] mb-2">Đúng: {{Support::show($examResult,'total_question_done')}}/{{Support::show($examResult,'total_question')}}</p>
    <p class="font-semibold text-[#252525] mb-2">Thời gian làm bài: {{sprintf('%02d phút %02d giây', ($examResult->total_time / 60 % 60), $examResult->total_time % 60)}}</p>
</div>