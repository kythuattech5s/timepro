<span class="rating {{ $class ?? '' }}" style="{{ isset($color) ? 'color:' . $color : '' }} {{ isset($size) ? '--size:' . $size.'px' : '' }}" {{ $attribute ?? '' }}>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <div class="rating--active" style="width:{{ $rating }};{{ isset($color) ? 'color:' . $color : '' }}">
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
        <i class="fa-solid fa-star"></i>
    </div>
</span>
