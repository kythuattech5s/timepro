@extends('index')
@section('main')
<div class="banner-pages ">
	<div class="link img_full block">
	    @include('image_loader.all',['keyImage'=>'img','itemImage'=>$currentItem])
	</div>
</div>
<div class="main-breadcrumb py-4 hidden">
	<div class="container">
	    {{Breadcrumbs::render('pages',$currentItem)}}
	</div>
</div>
<section class="section-new__detail 2xl:py-14 py-6">
	<div class="container">
        <h1 class="title-new font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1.125rem] mb-4">
            {{Support::show($currentItem,'name')}}
        </h1>
        <div class="s-content mb-6">
            {!! Support::show($currentItem,'content') !!}
        </div>
	</div>
</section>
@endsection