<label for="">{{ $type['label'] }}</label>
<select class="w-full border px-2 py-1" data-name="{{ $key }}" id="">
    @foreach ($type['options'] as $option)
        <option value="{{ $option['value'] }}" @if ($option['value'] == $value) selected @endif>{{ $option['name'] }}</option>
    @endforeach
</select>
