<p class="title">Đánh giá sản phẩm</p>
<div class="content">
    <form action="cmrs/source/danh-gia-san-pham" method="POST" class="form-rating form-validate" data-success="COMMENT_ORDER.success" check absolute gallery>
        <input type="hidden" name="map_table" value="products">
        <input type="hidden" name="order_id" value="{-order.id-}">
        @csrf
        @foreach ($order->orderProducts as $key => $item)
            @php
                $product = $item->product;
            @endphp
            <div class="product-rating">
                <div class="product mb-30">
                    <div class="d-flex align-items-center pb-20">
                        <a href="{-product.slug-}" title="{-product.name-}" class="img-prd d-block img__ mr-20">
                            <img src="{%IMGV2.product.img.350x0%}" alt="{%AIMGV2.product.img.alt%}" title="{%AIMGV2.product.img.title%}">
                        </a>
                        <div class="ct-content">
                            <a href="#" title="{-product.name-}" class="name-prd fz-16 f-bold cl-title clamp-2 mb-10">{-item.name-}</a>
                            <p class="fz-12 cl-gray">Phân loại: {-item.property-}</p>
                        </div>
                    </div>
                </div>
                @php
                    $product = App\Models\Product::find(Support::show($item, 'product_id'));
                @endphp
                <input type="hidden" name="map_id[]" value="{{ Support::show($product, 'parent') > 0 ? Support::show($product, 'parent') : Support::show($item, 'product_id') }}">
                <div class="head-form d-flex align-items-center justify-content-center mb-3">
                    @include('commentRS::selectStar', ['keySelectStar' => $key, 'size' => 32])
                </div>
                <div class="d-none">
                    <textarea class="form-control" name="content[]" class="content-comment" placeholder="Hãy chia sẻ những điều bạn thích về sản phẩm này nhé"></textarea>
                    @include('shop.components.file', ['name' => "img-$key", 'classInputFile' => 'mt-3', 'styleInputFile' => '--min-height:100px', 'classImageInputFile' => 'col-4 mt-3', 'maxFile' => 3])
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-end mt-3 gap-2">
            <button type="button" class="btn-base btn-gray-light" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn-base btn-main-bland">Đánh giá</button>
        </div>
    </form>
</div>
