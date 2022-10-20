<div class="table-responsive">
    <table class="table-statical-line table-statical-line-border">
        <thead>
            <tr class="font-weight-bold">
                <th style="width: 50px">STT</th>
                <th class="text-left">Tên thành viên</th>
                <th class="text-left">Số điện thoại</th>
                <th style="width: 300px;">Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listItems as $k => $item)
            <tr>
                <td><strong>{{$k+1}}</strong></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="img-item">
                            @include('image_loader.tiny',['itemImage'=>$item,'keyImage'=>'img'])
                        </div>
                        <span class="name-item text-left">
                            {{Support::show($item,'name')}}
                        </span>
                    </div>
                </td>
                <td class="text-left">{{Support::show($item,'phone')}}</td>
                <td>
                    <a href="esystem/xem-lich-su-hoc-cua-hoc-vien/{{Support::show($item,'id')}}" class="admin-btn-all d-inline-block" style="margin-right:5px;" title="Xem kết quả học" target="_blank">
                        Xem kết quả học
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination d-flex justify-content-center my-3">
    {{$listItems->withQueryString()->links('bases.pagination')}}
    </div>
</div>