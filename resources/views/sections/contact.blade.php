<section class="section-form relative lg:py-0 py-6">
    <div class="hidden lg:block bg-form absolute top-0 left-0 w-[60%] h-full img-ava">
        @include('image_loader.config.all',['config_key'=>'image_form_contact_about'])
    </div>
    <div class="hidden lg:block absolute top-0 right-0 w-[40%] h-full bg-no-repeat bg-[length:100%_100%]" style="background-image: url(theme/frontend/images/bg-form-2.png);"></div>
    <div class="container relative z-[1] lg:flex items-center justify-end 2xl:min-h-[700px] lg:min-h-[500px]">
        <form action="{{\VRoute::get('send_contact')}}" method="POST" class="formValidation form-regis max-w-[820px] lg:mr-0 mx-auto bg-white rounded-lg shadow-[6px_8px_48px_rgba(0,0,0,.1)] 2xl:p-8 lg:p-6 p-4" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
            @csrf
            <p class="text-center font-bold text-[#252525] uppercase 2xl:text-[2.5rem] lg:text-[1.875rem] text-[1.125rem] mb-2">
                {[title_form_contact_about]}
            </p>
            <div class="short_content text-center mb-6">
                {[content_form_contact_about]}
            </div>
            <div class="form relative">
                <input type="text" name="email" rules="required" placeholder="Nhập địa chỉ email của bạn..." class="form-control w-full py-3 px-4 outline-none bg-[#f5f5f5] rounded-lg">
                <button type="submit" class="btn btn-orange font-semibold absolute top-0 right-0 h-full inline-flex items-center justify-center p-2 px-4 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] text-white">Gửi thông tin</button>
            </div>
        </form>
    </div>
</section>