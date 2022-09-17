<div id="getCode" modal tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-[34rem] h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" >
            <button type="button" class="absolute top-[0.625rem] right-[0.625rem] z-10 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal" button_close_modal>
                <?php echo $__env->make('svg.icon_close', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <span class="sr-only">Close modal</span>
            </button>
            <h3 class="lg:text-[1.625rem] md:text-[1.225rem] text-[1.1rem] lg:pt-[2.5rem] md:pt-[2rem] pt-[1.5rem] font-semibold text-gray-900 dark:text-white text-center mb-1">Vui lòng nhập mã xác nhận</h3>
            <div class="desc text-[#454545] text-center lg:mb-[1.875rem] md:mb-[1.575rem] mb-[1.25rem] px-4">
                <?php echo trans('fdb::content_form_otp') ?>
            </div>
            <div class="p-6 space-y-6 pt-0">
                <form action="<?php echo e($actionFormOtpCode ?? ''); ?>" class="frm" method="post" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
                    <input type="hidden" name="otp" main-otp-rs="">
                    <div class="otp-rs flex lg:gap-[1rem] gap-[0.5rem] justify-center items-center mb-[1rem]">
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                        <input type="text" name="fake[]" class="sub-otp-rs w-[3rem] h-[3rem] border-[1px] border-[#EBEBEB] rounded rounded-[0.3125rem] overflow-hidden text-xl font-semibold text-center text-[#252525]" rules="required"/>
                    </div>
                    <div class="text-center lg:mb-[2.5rem] md:mb-[1.75rem] mb-[1.25rem]">
                        <span>Bạn chưa nhận được mã?</span>
                        <a href="javascript:void(0);" button_resend_code title="Yêu cầu gửi lại" class="text-[#17B06B] inline-block text-base">Yêu cầu gửi lại</a>
                    </div>
                    <button type="submit" class="rounded rounded-[0.3125rem] overflow-hidden px-[0.625rem] py-[0.825rem] bg-gradient-to-r from-[#F44336] to-[#C62828] text-white w-full">
                        Đồng ý
                    </button>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\timepro\resources\views/layouts/footer.blade.php ENDPATH**/ ?>