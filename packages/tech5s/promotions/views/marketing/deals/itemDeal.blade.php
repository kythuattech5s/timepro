<div class="d-flex justify-content-between">
    <h4 class="">Thông tin cơ bản</h4>
    <button class="btn btn-link edit-deal @if(isset($noEdit) && $noEdit) no-edit @endif" data-id="{-currentItem.id-}" data-action="{{$action}}">
        <i class="fa fa-pencil" aria-hidden="true"></i>
        Thay đổi
    </button>
</div>
<div class="info-deal">
    <div class="row">
        <div class="col-lg-4">
            <p>Loại Deal Sốc: {{ DealHelper::getNameType($currentItem->type) }}</p>
        </div>
        <div class="col-lg-4">
            <p>Tên Deal Sốc: {-currentItem.name-}</p>
        </div>
        <div class="col-lg-4">
            <p>Thời gian chương trình: {{ date('H:i d-m-Y', strtotime($currentItem->start_at)) }} -
                {{ date('H:i d-m-Y', strtotime($currentItem->expired_at)) }}</p>
        </div>
        <div class="col-lg-4">
            @if($currentItem->type == DealHelper::TYPE_DEAL)
            <p>Giới hạn sản phẩm mua kèm: {-currentItem.limit-}</p>
            @else
            <p>Điều kiện nhận quà: Mua <b>₫{{number_format($currentItem->price,0,',','.')}}</b> để nhận <b>{{$currentItem->qty}}</b> quà tặng</p>
            @endif
        </div>
    </div>
</div>
