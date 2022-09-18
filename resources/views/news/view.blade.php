@extends('index')
@section('main')
<div class="banner-pages ">
	<div class="link img_full block">
		@include('image_loader.all',['keyImage'=>'img','itemImage'=>$parent])
	</div>
</div>
<div class="main-breadcrumb py-4 hidden">
	<div class="container">
		{{Breadcrumbs::render('news',$currentItem,$parent)}}
	</div>
</div>
<section class="section-new__detail 2xl:py-14 py-6">
	<div class="container">
		<div class="grid grid-cols-1 lg:grid-cols-3 2xl:gap-6 gap-4">
			<div class="col-span-1 lg:col-span-2">
				<div class="rating-item mb-2">
					<p class="rating">
						<span class="rating-box">
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<span style="width:100%">
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
								<i class="fa fa-star" aria-hidden="true"></i>
							</span>
						</span>
					</p>
					<p>4.11/5 trong 5952 Đánh giá</p>
				</div>
				<h1 class="title-new font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1.125rem] mb-4">
					{{Support::show($currentItem,'name')}}
				</h1>
				<div class="s-content mb-6">
					{!! Support::show($currentItem,'content') !!}
				</div>
				@if(isset($tags) && count($tags))
				<ul class="tag-new mb-6">
					<li class="inline-block text-[0.875rem] font-semibold text-[#252525] mr-4">Tags:</li>
					@foreach($tags as $tag)
					<li class="inline-block lg:text-[0.875rem]  mr-4">
						<a href="{{Support::show($tag,'slug')}}" title="{{Support::show($tag,'name')}}" class="link inline-block text-[#888] bg-[#EBEBEB] rounded-[50px] py-1 px-3 hover:bg-[#F44336] hover:text-white whitespace-nowrap">
							{{Support::show($tag,'name')}}
						</a>
					</li>
					@endforeach
				</ul>
				@endif
				<div class="flex items-center justify-between mb-4 flex-wrap gap-2">
					<div class="rating-item mb-2">
						<p class="rating">
							<span class="rating-box">
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<span style="width:100%">
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
								</span>
							</span>
						</p>
					</div>
					<div class="flex items-center gap-4">
						<div class="like">
							<div id="fb-root"></div>
							<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0" nonce="ejJKIBLB"></script>
							<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="" data-layout="button" data-action="like" data-size="large" data-share="false"></div>
						</div>
						<ul>
							<li class="inline-block text-[0.875rem] text-[#252525] mr-4 last:mr-0">Chia sẻ: </li>
							<li class="inline-block mr-4 last:mr-0">
								<a href="#" title="Facebook" class="flex items-center justify-center w-6 h-6 rounded-full text-white bg-[#888] hover:bg-[#F44336] hover:text-white" target="_blank">
									<i class="fa fa-facebook text-[0.75rem]" aria-hidden="true"></i>
								</a>
							</li>
							<li class="inline-block mr-4 last:mr-0">
								<a href="#" title="Instagram" class="flex items-center justify-center w-6 h-6 rounded-full text-white bg-[#888] hover:bg-[#F44336] hover:text-white" target="_blank">
									<i class="fa fa-instagram text-[0.75rem]" aria-hidden="true"></i>
								</a>
							</li>
							<li class="inline-block mr-4 last:mr-0">
								<a href="#" title="Gmail" class="flex items-center justify-center w-6 h-6 rounded-full text-white bg-[#888] hover:bg-[#F44336] hover:text-white" target="_blank">
									<i class="fa fa-google text-[0.75rem]" aria-hidden="true"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="comment-facebook">
					<h2 class="title-all font-bold mb-3 text-[#252525]">Đánh giá bài viết! </h2>
					<div id="fb-root"></div>
					<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId={[fbappid]}&autoLogAppEvents=1" nonce="YTQOJB7h"></script>
					<div class="fb-comments" data-href="{{url()->current()}}" data-numposts="2" data-width="100%"></div>
				</div>
			</div>
			<div class="col-span-1">
				@include('news.sidebar')
			</div>
		</div>
	</div>
</section>
@if(isset($products) && count($products) > 0)
<section class="2xl:py-14 2xl:pt-6 py-6">
	<div class="container">
		<p class="font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.3rem] text-[1rem] 2xl:mb-6 mb-4">Khóa học gợi ý</p>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:gap-6 gap-4">
			@foreach($products as $itemProduct)
			<div class="col-span-1">
				@include('courses.item',['item'=>$itemProduct])
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif
@endsection