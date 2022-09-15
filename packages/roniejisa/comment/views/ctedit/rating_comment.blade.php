<?php

    $default_data = FCHelper::er($table, 'default_data');
    $default_data = json_decode($default_data, true);
    $default_data = @$default_data ? $default_data : [];
    $name = FCHelper::er($table, 'name');
    $name_field = FCHelper::er($default_data, 'field');
    $value = '';
    if ($actionType == 'edit' || $actionType == 'copy') {
        $detail = DB::table($default_data['table'])->where($default_data['field_relationship'],$dataItem->id)->first();
        $value = $detail->$name_field ?? 0;
    }
    // DB
    // {
    //     "table": "ratings",
    //     "field": "rating",
    //     "field_relationship":"comment_id",
    //     "field_duplicate": [
    //         "map_table",
    //         "order_id",
    //         "map_id",
    //         "user_id"
    //     ]
    // }
?>
<div class="form-group">
    <p class="form-title" for="">{{ FCHelper::er($table, 'note') }} <span class="count"></span></p>
</div>
<div class="rating-select">
    <div class="rating" m-checked="Vui lòng đánh giá">
        @for ($i = 5; $i > 0; $i--)
            <input class="star star-{{ $i }}" rules="required"
                id="star-{{ isset($key) ? $key . '-' : '' }}{{ $i }}" type="radio"
                value="{{ $i }}" name="{{$name}}" {{$i == $value ? 'checked' : ''}}/>
            <label class="star star-{{ $i }}"
                for="star-{{ isset($key) ? $key . '-' : '' }}{{ $i }}"></label>
        @endfor
    </div>
</div>
