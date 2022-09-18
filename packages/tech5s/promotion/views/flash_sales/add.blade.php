@extends('tp::flash_sales.view')
@section('tp_content')
    <div class="flash-sale">
        <form action="tp/flash-sale/store" method="POST" class="form-validate" plus="FLASH_SALE.checkTime" data-success="FLASH_SALE.createSuccess" absolute>
            @csrf
            <div class="rows">
                <div class="col-lg-9">
                    <div class="form-group">
                        <label for="name">Tên chương trình</label>
                        <input type="text" class="form-control" id="name" name="name" rules="required" m-required="Vui lòng nhập tên chương trình" placeholder="Nhập tên chương trình">
                    </div>
                    <div class="form-group flex items-center gap-3">
                        <label for="">Thời gian diễn ra</label>
                        <div class="flash-sale-datetime">
                            <button type="button" class="btn btn bg-yellow-300 text-black" data-toggle="modal" data-target="#flashSaleSlot">
                                Chọn khung giờ FlashSale
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="discount">Số tiền giảm giá</label>
                        <div class="flex gap-1">
                            <select name="promotion_type_comparison_id" class="select2 w-[100px]">
                                @foreach ($type_comparisons as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" placeholder="Số tiền" id="discount" rules="required" class="flex-1 rounded-[5px] border px-3" inf>
                            <input type="text" class="hidden" name="discount" placeholder="Số tiền">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="promotion_type_id">Áp dụng cho</label>
                        <select name="promotion_type_id" id="promotion_type_id" rules="required" class="w-full border p-3">
                            <option value="">-- Chọn điều kiện --</option>
                            @foreach ($types as $type)
                                <option value="{-type.id-}">{-type.name-}</option>
                            @endforeach
                        </select>
                        <textarea name="data" class="hidden"></textarea>
                        <div class="custom-search hidden"></div>
                        <div class="list-result-custom overscroll-x-hidden hidden max-h-[500px] overflow-y-auto border"></div>
                    </div>
                    <div class="form-group">
                        <label for="ord">Độ ưu tiên</label>
                        <input type="text" id="ord" class="form-control" placeholder="Độ ưu tiên" ord>
                    </div>
                    <div class="form-group">
                        <label for="switch-1" class="w-full">Kích hoạt</label>
                        <label for="switch-1" class="switch ml-2">
                            <input type="checkbox" name="act" id="switch-1" onchange="this.value = this.checked ? 1 : 0">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-3">
                    @include('tp::components.update_image')
                </div>
            </div>
            <span class="frag-footer"></span>
            <div class="form-footer">
                <a href="{{ base64_decode(request()->input('returnurl', base64_encode(url('esystem/views/flash_sales')))) }}" class="btn bg-red-400 text-white">Quay lại</a>
                <button type="submit" class="btn bg-green-400 text-white">Tạo chương trình</button>
            </div>
        </form>
    </div>
    @include('tp::flash_sales.components.ModalTimeSlot')
@endsection
