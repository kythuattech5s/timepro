@extends('vh::master')
@section('content')
    <input type="hidden" name="model" value="{{ request()->input('model') }}" />
    <input type="hidden" name="field_parent" value="{{ request()->input('parentField') }}" />
    @foreach (request()->all() as $key => $input)
        @if (strpos($key, 'plus_') !== false)
            <input type="hidden" plus-param name="{{ str_replace('plus_','',$key) }}" value="{{ $input }}" />
        @endif
    @endforeach
    <input type="hidden" name="view" value="{{ request()->input('view') }}" />
    <input type="hidden" name="view_item" value="{{ request()->input('view_item') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('comment/css/admin_comment.css') }}">
    <div class="card d-flex justify-content-between">
        <a href="{{ base64_decode(request()->input('returnurl')) }}" class="btn btn-red d-flex align-items-center justify-content-center">Quay lại</a>
        <p class="cart__title list-link">Chi tiết câu hỏi {{ $data->id }}</p>
    </div>
    <hr>
    @php
        $key = str_replace('s', '', $data->map_table);
        $item = $data->$key;
    @endphp
    @if ($item !== null)
        <div class="product-view">
            <a href="{{ $item->slug }}" class="product-view__img" target="_blank">
                <img src="{%IMGV2.item.img.390x0%}" alt="{%AIMGV2.item.img.alt%}" title="{%AIMGV2.item.img.title%}">
            </a>
            <div class="product-view__content">
                <a target="_blank" class="product-view__link" href="{{ $item->slug }}" title="">
                    {{ $item->name }}
                </a>
                <p class="product-view__price">{{ Currency::showMoney($item->price) }}</p>
            </div>
        </div>
    @endif
    <div class="comment-detail">
        @include('commentRS::comments.item', ['comment' => $data])
    </div>
@stop
@section('js')
    <script src="{'comment/js/admin_comment.js'}" defer></script>
@endsection
