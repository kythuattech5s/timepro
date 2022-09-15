<div class="d-flex comment-box__filter-header flex-wrap justify-content-between align-items-center">
    <p class="my-1"><span comment-count>{{$comments->total()}}</span> nhận xét</p>
    <div class="comment-sort my-1">
        <p>Sắp xếp theo:</p>
        <select name="sort" filter="rating">
            <option value="new">Mới nhất</option>
            <option value="old">Cũ nhất</option>
        </select>
    </div>
</div>
<div class="d-flex flex-wrap align-items-center comment-box__filter-content">
    <p class="title-filtler-text">Lọc xem theo:</p>
    <div class="comment-filter__lists" data-table="{{$map_table}}" data-id="{-currentItem.id-}">
        <input type="checkbox" name="filter" filter="rating" value="7" id="comment-filter-image" hidden>
        <label for="comment-filter-image">Có hình ảnh</label>
        {{-- <input type="checkbox" name="filter" filter="rating" value="6" id="comment-filter-buyed" hidden>
        <label for="comment-filter-buyed">Đã mua hàng</label> --}}
        <input type="checkbox" name="filter" filter="rating" value="5" id="comment-filter-5" hidden>
        <label for="comment-filter-5">5 <i class="fa-solid fa-star"></i></label>
        <input type="checkbox" name="filter" filter="rating" value="4" id="comment-filter-4" hidden>
        <label for="comment-filter-4">4 <i class="fa-solid fa-star"></i></label>
        <input type="checkbox" name="filter" filter="rating" value="3" id="comment-filter-3" hidden>
        <label for="comment-filter-3">3 <i class="fa-solid fa-star"></i></label>
        <input type="checkbox" name="filter" filter="rating" value="2" id="comment-filter-2" hidden>
        <label for="comment-filter-2">2 <i class="fa-solid fa-star"></i></label>
        <input type="checkbox" name="filter" filter="rating" value="1" id="comment-filter-1" hidden>
        <label for="comment-filter-1">1 <i class="fa-solid fa-star"></i></label>
    </div>
</div>