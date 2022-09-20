@extends('index')
@section('main')
<div class="banner-pages ">
    <div class="link img_full block">
        @include('image_loader.all',['keyImage'=>'img','itemImage'=>$currentItem])
    </div>
</div>
<div class="main-breadcrumb py-4 hidden">
    <div class="container">
        {{Breadcrumbs::render('static',trans('fdb::search_news'),\VRoute::get('search_news'))}}
    </div>
</div>
<section class="section-new 2xl:py-14 py-6">
    <div class="container">
        <div class="list-new__item">
            @foreach($listItems->skip(4) as $item)
                @include('news.item_horizontal')
            @endforeach
        </div>
        {{$listItems->withQueryString()->links('bases.pagination')}}
    </div>
</section>
@endsection