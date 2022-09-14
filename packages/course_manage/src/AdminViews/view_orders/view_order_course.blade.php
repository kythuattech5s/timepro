@php
    use App\Models\OrderStatus;
@endphp
@extends('vh::master')
@section('content')
<div class="header-top aclr">
	<div class="breadc pull-left">
		<ul class="aclr pull-left list-link">
			<li class="active"><a href="javascript:void(0)">Thông tin đơn hàng khóa học</a></li>
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
							<td>{{Support::show($orderCourse,'code')}}</td>
						</tr>
                        <tr>
							<td>Ngày tạo đơn</td>
							<td>{{Support::showDateTime($orderCourse->created_at)}}</td>
						</tr>
                        <tr>
							<td>Phương thức thanh toán</td>
							<td><span class="select-value">{{Support::show($orderCourse->paymentMethod,'name')}}</span></td>
						</tr>
						<tr>
							<td>Trạng thái đơn hàng</td>
							<td><span class="select-value">{{Support::show($orderCourse->orderStatus,'name')}}</span></td>
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
							<td>{{Support::show($orderCourse,'name')}}</td>
						</tr>
						<tr>
							<td>Số điện thoại</td>
							<td>{{Support::show($orderCourse,'phone')}}</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>{{Support::show($orderCourse,'email')}}</td>
						</tr>
						<tr>
							<td>Ghi chú</td>
							<td>{{Support::show($orderCourse,'content')}}</td>
						</tr>
					</tbody>
	    		</table>
	    	</div>
	    	<div class="col-lg-8 mt-4">
                @if ($orderCourse->changeStatusAble())
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-success mx-2 btn-change-order-course-status" data-status="{{OrderStatus::PAID}}" style="font-size: 16px;">Xác nhận đã thanh toán <i class="fa fa-check-square-o ms-2" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger mx-2 btn-change-order-course-status" data-status="{{OrderStatus::CANCEL}}" style="font-size: 16px;">Hủy đơn hàng <i class="fa fa-times ms-2" aria-hidden="true"></i></button>
                    </div>
                @endif
                <table class="table-view-order-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align: center!important;width: 60px">STT</th>
                            <th>Tên khóa học</th>
                            <th>Gói thời gian</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderCourse->orderCourseDetail as $key => $itemOrderCourseDetail)
                            <tr>
                                <td style="text-align: center!important"><strong>{{$key + 1}}</strong></td>
                                <td>{{Support::show($itemOrderCourseDetail,'name')}}</td>
                                <td>{{Support::show($itemOrderCourseDetail,'name_time_package')}}</td>
                                <td><strong>{{Currency::showMoney($itemOrderCourseDetail->price)}}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
	    		<div class="total-info text-right">
		    		<p class="item-total">Tổng tiền: <span>{{Currency::showMoney($orderCourse->total)}}</span></p>
		    		<p class="item-total item-total-final">Tổng tiền cuối cùng: <span>{{Currency::showMoney($orderCourse->total_final)}}</span></p>
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
                        url: 'esystem/course-manage/change-order-course-status',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            order_course: {{$orderCourse->id}},
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