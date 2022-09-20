<table>
    <thead>
    <tr>
        <th>STT</th>
        <th>Mã GD</th>
        <th>Ngày Nhập GD</th>
        <th>Ngày GD</th>
        <th>Số tiền</th>
        <th>Tên giao dịch</th>
        <th>Nội dung</th>
        <th>Trang thái</th>
    </tr>
    </thead>
    <tbody>
        @foreach($transactions as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{Support::show($item,'code')}}</td>
            <td>{{Support::show($item,'created_at')}}</td>
            <td>{{Support::show($item,'updated_at')}}</td>
            <td>{{App\Helpers\UserWallet\WalletHelper::getTypeTransaction(Support::show($item,'type')) == 1?'+':'-'}}{{Currency::showMoney(Support::show($item,'amount'))}}</td>
            <td>{{Support::show($item,'reason')}}</td>
            <td>{{Support::show($item,'content')}}</td>
            <td>
                @switch(Support::show($item,'status'))
                    @case(0)
                        {{'Đang chờ xử lý'}}
                        @break
                    @case(1)
                        {{'Thành công'}}
                        @break
                    @case(2)
                        {{'Hủy giao dịch'}}
                        @break
                @endswitch
            </td>
        </tr>
        @endforeach
    </tbody>
</table>