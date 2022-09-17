
@if(isset($currentItem) || isset($listChecked))
    @php
        $arrayIds = [];
        if(isset($listChecked)){
            $arrayIds = $listChecked->toArray();
        }else{
            $ids = $currentItem->categories->pluck('id');
            foreach($ids as $id){
                $arrayIds[] = [
                    'id' => (string) $id,
                ];
            }
        }
    @endphp
@endif
<table class="table m-0" m-checkbox="CATEGORY">
    <thead class="sticky top-0 bg-white shadow-md z-10">
        <tr>
            <th class="w-[100px]">
                <label for="all" >
                    <input id="all" type="checkbox" c-multiple>
                    <span></span>
                    <textarea class="hidden" name="data" c-data>
                        @isset($arrayIds)
                            {{json_encode($arrayIds,JSON_UNESCAPED_UNICODE)}}
                        @endisset
                    </textarea>
                </label>
            </th>
            <th>Tên danh mục</th>
        </tr>
    </thead>
    <tbody>
        @forelse($listData as $item)
            @php
                $checked = false;
                if(isset($currentItem)){
                    $dataSelected = $currentItem->categories->pluck('id');
                    $checked = $dataSelected->contains($item->id);
                }
                if(isset($listChecked)){
                    $checked = $listChecked->contains(function($data) use($item){
                        return isset($data['id']) && (int) $data['id'] == $item->id;
                    });
                }
            @endphp
            <tr>
                <td class="w-[100px]">
                    <label for="checkbox-{{$item->id}}" >
                        <input id="checkbox-{{$item->id}}" type="checkbox" @if($checked) checked @endif value="{{$item->id}}" c-single data-checked="id" data-checked-main>
                        <span></span>
                    </label>
                </td>
                <td>
                    <label for="checkbox-{{$item->id}}">
                        {{$item->name}}
                    </label>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan="100%">Không có danh mục nào hợp lệ!</td>
        </tr>
        @endforelse
    </tbody>
    @if($listData->count() > 0 && $listData->lastPage() > 1)
    <tfoot>
        <tr>
            <td colspan="100%">
                {{ $listData->withQueryString()->links('vendor.pagination.pagination') }}
            </td>
        </tr>
    </tfoot>
    @endif
</table>