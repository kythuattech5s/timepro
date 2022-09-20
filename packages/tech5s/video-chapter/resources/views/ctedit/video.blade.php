@php
$name = Support::show($table, 'name');
$default_data = Support::show($table, 'default_data');
$default_code = Support::show($table, 'default_code');
$note = Support::show($table, 'note');
$default_data = json_decode($default_data, true);
$fields = Support::show($default_data, 'fields');

$dataValue = [];
if ($actionType == 'edit') {
    $relationship = Support::show($table, 'relationship');
    $relationship = json_decode($relationship, true);
    $nameRelationship = $relationship['data'][0]['name'];
    $dataValue = $dataItem->$nameRelationship->toArray();
}
@endphp
<div>
    <label for="">Video khóa học</label>
</div>
<div tech5s-video-chapter="{{ $name }}" class="border" field-list="{{ json_encode($fields) }}">
    <textarea name="{{ $name }}" class="hidden" id="" cols="30" rows="10">{{ json_encode($dataValue) }}</textarea>
    <p class="bg-[#212529] p-3 uppercase text-white">List {{ $note }}</p>
    <div list-items="{{ $name }}" class="grid grid-cols-4 gap-3 p-3 xl:grid-cols-5">
        @foreach ($dataValue as $item)
            @php
                unset($item['created_at']);
                unset($item['updated_at']);
            @endphp

            <div class="relative col-span-1 border border-[#212529] p-2" item>
                <button type="button" remove-item class="absolute top-1 right-1 h-10 w-10 bg-orange-500 text-white"><i class="fa fa-times" aria-hidden="true"></i></button>
                @foreach ($item as $key => $value)
                    @php
                        $types = array_filter(
                            $fields,
                            function ($q, $index) use ($key, $value) {
                                return $q['name'] === $key;
                            },
                            ARRAY_FILTER_USE_BOTH,
                        );
                    @endphp
                    @if (count($types) == 0 && !in_array($key, ['duration']))
                        <input type="hidden" data-name="{{ $key }}" value="{{ $value }}">
                    @else
                        @foreach ($types as $type)
                            @include('TVC::types.' . $type['type'])
                        @endforeach
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="p-2 text-center">
        <button type="button" class="mx-auto bg-blue-500 p-3 text-white" add-item><i class="fa fa-plus" aria-hidden="true"></i> Thêm {{ $note }}</button>
    </div>
</div>
