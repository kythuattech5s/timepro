<form action="{{\VRoute::get('search_news')}}" method="GET" class="form-search-new relative rounded-lg overflow-hidden 2xlmb-6 mb-4">
    <input type="text" name="keyworđ" placeholder="Tìm kiếm tin tức..." class="form-control rounded-lg w-full py-3 px-4 border-[1px] border-solid border-[#ebebeb] outline-none pr-14">
    <button type="submit" class="btn-search absolute top-0 right-0 z-[1] h-full flex items-center justify-center p-4 bg-gradient-to-r from-[#F44336] to-[#C62828] text-white text-[1.25rem]"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>
@if($table == 'news_categories')
	@if(isset($listNewsSale) && count($listNewsSale) > 0)
	<div class="head-new__sidebar relative flex items-center justify-between pb-2 border-b-[1px] border-solid border-[#ebebeb] after:absolute after:h-[2px] after:w-[180px] after:bottom-0 after:left-0 after:bg-[#F44336] 2xl:mb-6 mb-4">
	    <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem]">Tin khuyến mãi</p>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-4 mb-6">
		@foreach($listNewsNew as $itemNewsNew)
	    <div class="col-span-1">
	        @include('news.item_sidebar',['item'=>$itemNewsNew])
	    </div>
	    @endforeach
	</div>
	@endif
	@if(isset($newsHighViews) && count($newsHighViews) > 0)
	<div class="head-new__sidebar relative flex items-center justify-between pb-2 border-b-[1px] border-solid border-[#ebebeb] after:absolute after:h-[2px] after:w-[180px] after:bottom-0 after:left-0 after:bg-[#F44336] 2xl:mb-6 mb-4">
	    <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem]">Tin đọc nhiều</p>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-4 mb-6">
		@foreach($newsHighViews as $itemNewsHightView)
	    <div class="col-span-1">
	        @include('news.item_sidebar',['item'=>$itemNewsHightView])
	    </div>
	    @endforeach
	</div>
	@endif
@endif
@if($table == 'news')
	<div class="head-new__sidebar relative flex items-center justify-between pb-2 border-b-[1px] border-solid border-[#ebebeb] after:absolute after:h-[2px] after:w-[180px] after:bottom-0 after:left-0 after:bg-[#F44336] 2xl:mb-6 mb-4">
	    <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem]">Danh mục tin</p>
	</div>
	{!! Support::printMenuCate($listAllNewsCategory,0,0) !!}
	@if(count($newsRelateds) > 0)
	<div class="head-new__sidebar relative flex items-center justify-between pb-2 border-b-[1px] border-solid border-[#ebebeb] after:absolute after:h-[2px] after:w-[180px] after:bottom-0 after:left-0 after:bg-[#F44336] 2xl:mb-6 mb-4">
	    <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem]">Tin tức liên quan</p>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-4 mb-6">
		@foreach($newsRelateds as $itemRelated)
	    <div class="col-span-1">
	        @include('news.item_sidebar',['item'=>$itemRelated])
	    </div>
	    @endforeach
	</div>
	@endif
@endif


@if(isset($listNewsSale) && count($listNewsSale) > 0)
<div class="head-new__sidebar relative flex items-center justify-between pb-2 border-b-[1px] border-solid border-[#ebebeb] after:absolute after:h-[2px] after:w-[180px] after:bottom-0 after:left-0 after:bg-[#F44336] 2xl:mb-6 mb-4">
    <p class="title font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem]">Tin khuyến mãi</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-4 mb-6">
	@foreach($listNewsSale as $itemNewsSale)
    <div class="col-span-1">
        @include('news.item_sidebar',['item'=>$itemNewsSale])
    </div>
    @endforeach
</div>
@endif