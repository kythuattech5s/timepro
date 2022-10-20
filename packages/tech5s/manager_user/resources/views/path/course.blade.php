<div class="table-responsive">
    <table class="table-statical-line table-statical-line-border">
        <thead>
            <tr class="font-weight-bold">
                <th style="width: 50px">STT</th>
                <th class="text-left">Tên khóa học</th>
                <th style="width: 100px;">Chi tiết</th>
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
                <td><a href="esystem/thong-ke-nguoi-hoc-cua-khoa-hoc/{{Support::show($item,'id')}}" class="admin-btn-all" title="Xem" target="_blank">Xem</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination d-flex justify-content-center my-3">
    {{$listItems->withQueryString()->links('bases.pagination')}}
    </div>
</div>