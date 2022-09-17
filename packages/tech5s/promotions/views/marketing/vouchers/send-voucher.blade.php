@extends('tech5spromotion::marketing.view')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('tech5sMarketing/css/marketing/voucher.css') }}">
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="card" m-checkbox="SET_NOTIFICAITON_VOUCHER_{-voucher.id-}">
            <div class="card-header d-flex justify-content-between mb-4">
                <h4 class="card-title list-link">Gửi thông báo Voucher</h4>
                <div class="d-flex">
                    <button type="button" class="me-3 btn bg-blue-400 text-white send-voucher-for-user select" c-disabled disabled data-id="{-voucher.id-}">Gửi theo
                        danh sách đã chọn</button>
                    <button type="button" class="btn bg-green-400 text-white duration-300 send-voucher-for-user all" data-id="{-voucher.id-}">
                        Gửi đến tất cả khách hàng
                    </button>
                </div>
            </div>
            <div class="card-table">
                <table class="table bordered">
                    <thead>
                        <tr>
                            <th>
                                <label class="d-block" for="product-multiple-modal">
                                    <input type="checkbox" id="product-multiple-modal" c-multiple>
                                    <span></span>
                                </label>
                                <textarea style="display:none" name="product_choose" id="" cols="30" rows="10" c-data></textarea>
                            </th>
                            <th>
                                STT
                            </th>
                            <th>
                                Tên khách hàng
                            </th>
                            <th>
                                Sô điện thoại
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                        <tr>
                            <td>
                                <label for="user-{{ $key }}">
                                    <input type="checkbox" id="user-{{ $key }}" name="user_id" value="{{ $user->id }}" c-single>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                {-user.name-}
                            </td>
                            <td>
                                {-user.phone-}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
