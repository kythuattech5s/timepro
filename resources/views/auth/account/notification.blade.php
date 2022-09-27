@extends('index')
@section('main')
    <section class="bg-[#EEEAEA] py-6 2xl:py-8">
        <div class="container">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 2xl:gap-8">
                <div class="col-span-1">
                    @php
                        $user = Auth::user();
                    @endphp
                    @if ($user->isAccount())
                        @include('auth.account.sidebar')
                    @else
                        @include('auth.teacher.sidebar')
                    @endif
                </div>
                <div class="col-span-1 lg:col-span-3">
                    <div class="mb-4 box-content rounded bg-white p-4 last:mb-0 2xl:mb-6">
                        <form action="" method="GET" class="form-search relative">
                            <i class="fa fa-search absolute top-1/2 left-4 -translate-y-1/2 text-[#888]" aria-hidden="true"></i>
                            <input type="text" name="q" value="{{request()->input('q')}}" placeholder="Nhập từ khóa tìm kiếm..." class="form-control w-full rounded-[1.25rem] bg-[#f5f5f5] py-3 pl-10 pr-32 outline-none">
                            <button type="submit" title="Tìm kiếm" class="btn btn-red-gradien absolute top-0 right-0 inline-flex h-full items-center justify-center rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-6 font-semibold text-white">
                                Tìm kiếm
                            </button>
                        </form>
                    </div>
                    <div class="mb-4 box-content rounded bg-white p-4 last:mb-0 2xl:mb-6">
                        <p
                           class="title mb-4 text-center text-[1rem] font-bold text-[#252525] lg:text-[1.25rem] 2xl:text-[1.6rem]">
                            Thông báo
                        </p>
                        <div
                             class="button-tabs tab-info-lesson mb-4 flex flex-wrap justify-center border-b-[1px] border-solid border-[#ebebeb] px-4 text-center sm:block lg:px-10 2xl:mb-6 2xl:px-20">
                            <button class="tablinks active basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-all" data-target="tab-lesson">Thông báo chung</button>
                            @foreach ($notification_catalogs as $catalog)
                                <button class="tablinks basis-1/2 border-b-[2px] border-solid border-transparent py-4 font-bold last:mr-0 sm:mr-4 lg:mr-8 2xl:mr-16 2xl:text-[1.25rem]" data-electronic="tab-lesson-{{ $catalog->id }}" data-target="tab-lesson">{{ Support::show($catalog, 'name') }}</button>
                            @endforeach

                        </div>
                        <div class="wrapper_tabcontent mb-4">
                            <div class="tabcontent active" data-target="tab-lesson" id="tab-lesson-all">
                                <div class="noti-list__item">
                                    @include('auth.account.components.list_notifications', ['notifications' => $notifications])
                                </div>
                                @if (!$notifications->onLastPage())
                                    <a load-more-notification href="javascript:void(0)" data-catalog="all" data-page="{{ $notifications->currentPage() + 1 }}" title="Xem thêm" class="readmore-noti mx-auto mt-6 block w-fit text-[0.845rem] font-semibold text-[#252525]">
                                        Xem thêm <i class="fa fa-caret-down ml-1" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                            @foreach ($notification_catalogs as $key => $catalog)
                                <div class="tabcontent" data-target="tab-lesson" id="tab-lesson-{{ $catalog->id }}">
                                    @php
                                        $notifications = $catalog->notifications()->where('notifiable_id',Auth::id())->paginate(10);
                                    @endphp
                                    <div class="noti-list__item">
                                        @include('auth.account.components.list_notifications', ['notifications' => $notifications])
                                    </div>
                                    @if (!$notifications->onLastPage())
                                        <a load-more-notification href="javascript:void(0)" data-catalog="{{ $catalog->id }}" data-page="{{ $notifications->currentPage() + 1 }}" title="Xem thêm" class="readmore-noti mx-auto mt-6 block w-fit text-[0.845rem] font-semibold text-[#252525]"> Xem thêm <i class="fa fa-caret-down ml-1" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script type="module" src="{'assets/plugins/notification/notification.js'}" defer></script>
@endsection
