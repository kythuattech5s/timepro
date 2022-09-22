@foreach($listData as $item)
@php
    $checked = false;
    if(isset($currentItem)){
        $dataSelected = $currentItem->categories->pluck('id');
        $checked = $dataSelected->contains($item->id);
    }
@endphp
<div class="item-category py-2" data-id="{{$item->id}}">
    <div class="flex space-x-2 justify-start item items-center">
        @if($item->childs->count() > 0)
            <i class="fa fa-plus-circle text-blue-400 cursor-pointer" aria-hidden="true"></i>
        @endif
        <label for="category-checkbox-{{$item->id}}" class="flex space-x-3 my-0 items-center">
            <p class="flex-[0 0 100px]">{{$item->name}}</p>
            <input type="checkbox" name="category" value="{{$item->id}}" @if($checked) checked @endif class="hidden" id="category-checkbox-{{$item->id}}">
            <span class="checkbox-item"></span>
        </label>
    </div>
</div>
@endforeach