@php
    use App\Models\OrderStatus;
@endphp
@extends('vh::master')
@section('content')
<div class="header-top aclr">
	<div class="breadc pull-left">
		<ul class="aclr pull-left list-link">
			<li class="active"><a href="javascript:void(0)">Thông tin đơn hàng gói Vip</a></li>
		</ul>
	</div>
	<div>
		<a class="pull-right bgmain1 viewsite" href="{{ $returnUrl }}">
			<i class="fa fa-backward" aria-hidden="true"></i>
			<span class="clfff">Back</span> 
		</a>
	</div>
</div>
<div id="maincontent">
	<div id="main_view_order">
	    <div class="row d-flex flex-wrap justify-content-center">
            <div class="col-lg-4 mt-4">
	    		<p class="title text-center">Thông tin đơn hàng</p>
	    		<table class="table-view-order">
					<tbody>
						<tr>
							<td>Mã đơn hàng</td>
							<td>{{Support::show($orderCourseCombo,'code')}}</td>
						</tr>
                        <tr>
							<td>Ngày tạo đơn</td>
							<td>{{Support::showDateTime($orderCourseCombo->created_at)}}</td>
						</tr>
                        <tr>
							<td>Phương thức thanh toán</td>
							<td><span class="select-value">{{Support::show($orderCourseCombo->paymentMethod,'name')}}</span></td>
						</tr>
						<tr>
							<td>Trạng thái đơn hàng</td>
							<td><span class="select-value">{{Support::show($orderCourseCombo->orderStatus,'name')}}</span></td>
						</tr>
					</tbody>
	    		</table>
	    	</div>
	    	<div class="col-lg-4 mt-4">
	    		<p class="title text-center">Thông tin khách hàng</p>
	    		<table class="table-view-order">
					<tbody>
						<tr>
							<td>Tên người mua</td>
							<td>{{Support::show($orderCourseCombo,'name')}}</td>
						</tr>
						<tr>
							<td>Số điện thoại</td>
							<td>{{Support::show($orderCourseCombo,'phone')}}</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>{{Support::show($orderCourseCombo,'email')}}</td>
						</tr>
						<tr>
							<td>Ghi chú</td>
							<td>{{Support::show($orderCourseCombo,'content')}}</td>
						</tr>
					</tbody>
	    		</table>
	    	</div>
	    	<div class="col-lg-8 mt-4">
                @if ($orderCourseCombo->changeStatusAble())
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-success mx-2 btn-change-order-course-status" data-status="{{OrderStatus::PAID}}" style="font-size: 16px;">Xác nhận đã thanh toán <i class="fa fa-check-square-o ms-2" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger mx-2 btn-change-order-course-status" data-status="{{OrderStatus::CANCEL}}" style="font-size: 16px;">Hủy đơn hàng <i class="fa fa-times ms-2" aria-hidden="true"></i></button>
                    </div>
                @endif
                <table class="table-view-order-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align: center!important;width: 60px">STT</th>
                            <th>Tên gói vip</th>
                            <th>Gói thời gian</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderCourseCombo->orderCourseComboDetail as $key => $itemOrderCourseComboDetail)
                            <tr>
                                <td style="text-align: center!important"><strong>{{$key + 1}}</strong></td>
                                <td>{{Support::show($itemOrderCourseComboDetail,'name')}}</td>
                                <td>{{Support::show($itemOrderCourseComboDetail,'name_time_package')}}</td>
                                <td><strong>{{Currency::showMoney($itemOrderCourseComboDetail->price)}}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
	    		<div class="total-info text-right">
		    		<p class="item-total">Tổng tiền: <span>{{Currency::showMoney($orderCourseCombo->total)}}</span></p>
		    		<p class="item-total item-total-final">Tổng tiền cuối cùng: <span>{{Currency::showMoney($orderCourseCombo->total_final)}}</span></p>
	    		</div>
	    	</div>
	    </div>
	</div>
</div>
@stop
@section('js')
    <script>
        var MANAGE_ORDER = (function(){
            var initButtonChangeStatus = function(){
                $(document).on('click','.btn-change-order-course-status',function(){
                    $.ajax({
                        url: 'esystem/course-manage/change-order-course-combo-status',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            order_course_combo: {{$orderCourseCombo->id}},
                            status: $(this).data('status')
                        }
                    })
                    .done(function(data) {
                        alert(data.message);
                        window.location.reload();
                    })
                });
            }
            return {
                _(){
                    initButtonChangeStatus();
                }
            };
        })();
        $(document).ready(function () {
            MANAGE_ORDER._();
        });
    </script>
@endsection