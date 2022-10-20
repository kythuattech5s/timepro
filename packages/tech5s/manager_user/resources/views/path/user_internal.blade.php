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
                        <img src="admin/statical/images/notebook.png" alt="">
                    </a>
                    <a href="esystem/search/exam_results?raw_id_type_filter=~%3D&raw_id=&raw_user_id={{Support::show($item,'id')}}&raw_course_id=&raw_exam_id=&orderkey=id&ordervalue=desc&limit=100" style="margin-right:5px;" class="admin-btn-all d-inline-block" title="Xem kết quả bài kiểm tra" target="_blank">
                        <img src="admin/statical/images/test.png" alt="">
                    </a>
                    <a href="esystem/search/obligatory_exam_results?raw_id_type_filter=~%3D&raw_id=&raw_user_id={{Support::show($item,'id')}}&raw_obligatory_exam_id=&orderkey=id&ordervalue=desc&limit=100" class="admin-btn-all d-inline-block" title="Xem kết quả thi" target="_blank">
                        <img src="admin/statical/images/exam.png" alt="">
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