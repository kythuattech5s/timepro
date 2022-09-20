@extends('index')
@section('main')
<div class="main-breadcrumb py-4 hidden">
    <div class="container">
        {{Breadcrumbs::render('static',trans('fdb::search_news'),\VRoute::get('search_news'))}}
    </div>
</div>
<section class="section-new 2xl:py-14 py-6">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-3 2xl:gap-6 gap-4">
            <div class="col-span-1 lg:col-span-2">
                <div class="list-new__item">
                    @foreach($listItems as $item)
                        @include('news.item_horizontal')
                    @endforeach
                </div>
                {{$listItems->withQueryString()->links('bases.pagination')}}
            </div>
            <div class="col-span-1">
                @include('news.sidebar')
            </div>
        </div>
    </div>
</section>
@endsection