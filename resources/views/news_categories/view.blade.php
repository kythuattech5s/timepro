@extends('index')
@section('main')
<div class="banner-pages ">
    <div class="link img_full block">
        @include('image_loader.all',['keyImage'=>'img','itemImage'=>$currentItem])
    </div>
</div>
<div class="main-breadcrumb py-4 hidden">
    <div class="container">
    	{{Breadcrumbs::render('news_category',$currentItem)}}
    </div>
</div>
<section class="section-new 2xl:py-14 py-6">
    <div class="container">
        <div class="nav-link__new  border-b-[1px] border-solid border-[#ebebeb] text-center 2xl:mb-6 mb-4 mb-6">
            @foreach($listAllNewsCategory as $itemNewsCategory)
            <a href="{(itemNewsCategory.slug)}" title="{(itemNewsCategory.name)}" class="font-bold inline-block 2xl:text-[1.25rem] uppercase py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0 active">
                {(itemNewsCategory.name)}
            </a>
            @endforeach
        </div>
        <?php 
            $newsBig = $listItems->first();
            $newsBottomBig = $listItems->skip(1)->take(3);
        ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 2xl:gap-6 gap-4">
            <div class="col-span-1 lg:col-span-2">
                @if(isset($newsBig))
                <div class="new-main relative rounded-lg overflow-hidden after:absolute after:bottom-0 after:left-0 after:w-full after:h-[30%] after:bg-gradient-to-b after:from-[rgba(0,0,0,0)] after:to-[rgba(0,0,0,0.8)] 2xl:mb-6 mb-4">
                    <a href="{{Support::show($newsBig,'slug')}}" title="{{Support::show($newsBig,'name')}}" class="img img__ c-img block pt-[56%]">
                        @include('image_loader.all',['keyImage'=>'img','itemImage'=>$newsBig])
                    </a>
                    <div class="new-content absolute bottom-0 left-0 w-full z-[1] text-white 2xl:p-4 p-2">
                        <span class="type inline-block text-white font-semibold uppercase lg:text-[0.875rem] py-2 px-3 bg-[#C90000] rounded mb-2">Nổi bật</span>
                        <h3>
                            <a href="{{Support::show($newsBig,'slug')}}" title="{{Support::show($newsBig,'name')}}" class="title font-bold 2xl:text-[1.375rem] lg:text-[1rem] text-[0.875rem] ">
                                {{Support::show($newsBig,'name')}}
                            </a>
                        </h3>
                    </div>
                </div>
                @endif
                <div class="hidden md:grid grid-cols-3 2xl:gap-6 gap-4 2xl:mb-6 mb-4">
                    @foreach($newsBottomBig as $itemBottomBig)
                    <div class="col-span-1">
                        @include('news.item_vertical',['item'=>$itemBottomBig])
                    </div>
                    @endforeach
                </div>
                <div class="list-new__item">
                    @foreach($listItems->skip(4) as $item)
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