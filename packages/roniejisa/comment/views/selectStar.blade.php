<div class="rating-select" @if (isset($size) && $size) style="--font-size-select:{{ $size }}px" @endif>
    <div class="rating">
        @for ($i = 5; $i > 0; $i--)
            <input class="star star-{{ $i }}" rules="required" id="star-{{ isset($keySelectStar) ? $keySelectStar . '-' : '' }}{{ $i }}" type="radio"
                   value="{{ $i }}" name="{{ $name ?? 'rate' }}{{ isset($keySelectStar) ? '-' . $keySelectStar : '' }}" @if (isset($rate) && $rate && $rate == $i) checked @endif @if (isset($rate) && $rate && $rate != $i) disabled @endif />
            <label class="star star-{{ $i }}" for="star-{{ isset($keySelectStar) ? $keySelectStar . '-' : '' }}{{ $i }}"></label>
        @endfor
    </div>
</div>
