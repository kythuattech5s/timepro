@php
if (isset($dataItem->map_table)) {
    $data = DB::table($dataItem->map_table)
        ->select('id', 'name')
        ->where('id', FCHelper::ep($dataItem, $show->name))
        ->first();
}
@endphp
@if (isset($data) && $data !== null)
    <p> {{ FCHelper::ep($data, 'name') }} </p>
@endif
