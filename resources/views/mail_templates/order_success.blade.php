@extends('mail_templates.main_template')
@section('content')
<div style="margin-bottom: 10px;">
    {[content_email_order_success]}
</div>
<table style="width: 100%;border-spacing:0;text-align: left;margin-bottom: 30px;border-collapse: collapse;margin-top: 15px">
	<thead>
		<tr>
			<th colspan="2" style="border:solid 1px #999999;padding: 5px;background: #343a40;color: #f8f9fa;text-align: center">Thông tin đơn hàng</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="border:solid 1px #999999;padding: 5px;width:180px;"><strong>Mã đơn</strong></td>
			<td style="border:solid 1px #999999;padding: 5px"><strong>{{$order->code}}</strong></td>
		</tr>
		<tr style="background: #f2f2f2">
			<td style="border:solid 1px #999999;padding: 5px;width:180px;"><strong>Tên người đặt hàng</strong></td>
			<td style="border:solid 1px #999999;padding: 5px">{{$order->name}}</td>
		</tr>
        <tr>
			<td style="border:solid 1px #999999;padding: 5px;width:180px;"><strong>Số điện thoại</strong></td>
			<td style="border:solid 1px #999999;padding: 5px">{{$order->phone}}</td>
		</tr>
        <tr style="background: #f2f2f2">
			<td style="border:solid 1px #999999;padding: 5px;width:180px;"><strong>Email</strong></td>
			<td style="border:solid 1px #999999;padding: 5px">{{$order->email}}</td>
		</tr>
        <tr>
			<td style="border:solid 1px #999999;padding: 5px;width:180px;"><strong>Phương thức thanh toán</strong></td>
			<td style="border:solid 1px #999999;padding: 5px">{{Support::show($order->paymentMethod,'name')}}</td>
		</tr>
		<tr style="background: #f2f2f2">
			<td style="border:solid 1px #999999;padding: 5px;width:180px;"><strong>Ghi chú</strong></td>
			<td style="border:solid 1px #999999;padding: 5px">{{Support::show($order->paymentMethod,'content')}}</td>
		</tr>
		<tr>
			<td style="border:solid 1px #999999;padding: 5px;width:180px;"><strong>Ngày đặt hàng</strong></td>
			<td style="border:solid 1px #999999;padding: 5px">{{Support::showDateTime($order->created_at,'d/m/Y H:i:s')}}</td>
		</tr>
	</tbody>
</table>
<table style="width: 100%;border-spacing:0;text-align: left;margin-bottom: 30px;border-collapse: collapse;margin-top: 15px">
	<thead>
		<tr>
			<th colspan="5" style="border:solid 1px #999999;padding: 5px;background: #343a40;color: #f8f9fa;text-align: center">Thông tin sản phẩm</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="border:solid 1px #999999;padding: 5px;width:40px;text-align: center;"><strong>STT</strong></td>
			<td style="border:solid 1px #999999;padding: 5px"><strong>Loại sản phẩm</strong></td>
			<td style="border:solid 1px #999999;padding: 5px"><strong>Tên sản phẩm</strong></td>
			<td style="border:solid 1px #999999;padding: 5px"><strong>Gói</strong></td>
			<td style="border:solid 1px #999999;padding: 5px"><strong>Giá</strong></td>
		</tr>
        @foreach ($listItemOrderDetail as $key => $itemOrderDetail)
            <tr>
                <td style="border:solid 1px #999999;padding: 5px;width:40px;text-align: center;"><strong>{{$key + 1}}</strong></td>
                <td style="border:solid 1px #999999;padding: 5px">{{$itemOrderDetail->getTypeName()}}</td>
                <td style="border:solid 1px #999999;padding: 5px">
                    <a href="{{url()->to(Support::show($itemOrderDetail,'slug'))}}" title="{{Support::show($itemOrderDetail,'name')}}" target="_blank">{{Support::show($itemOrderDetail,'name')}}</a>
                </td>
                <td style="border:solid 1px #999999;padding: 5px">{{Support::show($itemOrderDetail,'name_time_package')}}</td>
                <td style="border:solid 1px #999999;padding: 5px"><strong>{{Currency::showMoney($itemOrderDetail->price)}}</strong></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="border:solid 1px #999999;padding: 5px;text-align: right">Tổng</td>
            <td style="border:solid 1px #999999;padding: 5px;font-size: 16px;"><strong>{{Currency::showMoney($order->total_final)}}</strong></td>
        </tr>
	</tbody>
</table>
@endsection